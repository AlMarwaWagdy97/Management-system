<?php

namespace App\Http\Controllers\Site;

use App\Models\Accounts;
use App\Models\CreditCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Site\CheckoutController;
use App\Charity\PaymentGateways\PayfortCustomerMerchant;
use App\Models\Cart;
use App\Models\Donor;
use App\Models\Order;
use Illuminate\Support\Str;

class PaymentController extends Controller
{

    public $testMode = true;

    public function __construct()
    {
        $this->testMode = config('app.TEST_MODE');
    }

    /**
     * intilalizse payfort and create order
     *
     * @param Request $request
     *
     * @return [type]
     */
    public function payfortIntital(Request $request)
    {
        $data = $request->all();
        //    if new card or selected saved card
        if (!isset($data['selected_card'])) {
            $card_data = [
                'card_number'               => $data['card_number'],
                'expiry_date'               => $data['expired_year'] . $data['expired_month'],
                'card_security_code'        => $data['cvv'],
                'card_holder_name'          => $data['card_name'],
            ];
        } else {
            $cardInfo = CreditCard::find(@$data['selected_card']);
            $card_data = [
                'card_number'           => (@$cardInfo->number),
                'expiry_date'           => decrypt(@$cardInfo->expired_year) . decrypt(@$cardInfo->expired_month),
                'card_security_code'    => $data['selected_cvv'],
                'card_holder_name'      => base64_decode(@$cardInfo->name),
            ];
        }

        //   Make th order in database
        $order = new CheckoutController();
        $orderData = $order->process($data);
        //   if card is saved for feature purchase [it saves with status 0]
        if (@$data['savecard']) {
            $carddata = [
                'number'             => ($card_data['card_number']),
                'expired_month'      => encrypt($data['expired_month']),
                'expired_year'       => encrypt($data['expired_year']),
                'name'               => base64_encode($card_data['card_holder_name']),
                'donor_id'           => @auth()->user()->donor?->id,
                'merchant_reference' => $orderData['order']->identifier,
                'default'            => 1,
            ];

            CreditCard::create($carddata);
        }
        // call payfort Custom MerchantToken
        $payment = new PayfortCustomerMerchant();

        if ($this->testMode) {
            $redirectUrl = 'https://sbcheckout.payfort.com/FortAPI/paymentPage';
        } else {
            $redirectUrl = 'https://checkout.payfort.com/FortAPI/paymentPage';
        }

        $payment->return_url = route('api.payfort-intital');
        $payment->merchant_reference = 'AUTH3_' . $orderData['order']->identifier;
        $parameters = $payment->CustomMerchantToken($card_data);

        echo "<html xmlns='http://www.w3.org/1999/xhtml'>\n<head></head>\n<body>\n";
        echo '';
        echo '<div style="position:fixed; top:40%;right:50%;text-align: center;font-weight: bold;color: yellowgreen;" ><img src="' . site_path('img') . '/icon.gif"/>
            <p>   سيتم التحقيق من البينات </p></div>';
        echo "<form action='$redirectUrl' method='post' name='frm'>\n";
        foreach ($parameters as $a => $b) {
            echo "\t<input type='hidden' name='" . htmlentities($a) . "' value='" . htmlentities($b) . "'>\n";
        }
        echo "\t<script type='text/javascript'>\n";
        echo "\t\tdocument.frm.submit();\n";
        echo "\t</script>\n";
        echo "</form>\n</body>\n</html>";
    }



    /**
     * check the authorization and response of initial payfot and send to purchase
     *
     * @param Request $request
     *
     * @return [type]
     */
    public function authorizateResponse(Request $request)
    {
        $response = $request->all();
        unset($response['url'], $response['token_name'], $response['r'], $response['return_url'], $response['language'], $response['merchant_identifier']);
        $meta = json_encode($response);

        ($response['status'] == 18) ? $status = 1 : $status = 0;
        if ($status == 1) {

            $order = Order::with('donor', 'details.project')->where('identifier',  str_replace('AUTH3_', '', $response['merchant_reference']))->get()->first();
            $order->payment_proof = $meta;
            $order->save();

            $payment = new PayfortCustomerMerchant();
            $payment->amount = $order->total;
            $payment->merchant_reference = $order->identifier;
            $payment->order_description = @$order->source . " Checkout";
            $payment->return_url = route('api.payfort-purchase');
            $donor =  $order?->donor;
            // check if any project hase a recurring option
            if ($this->hasRecurring($order->details)) {
                $payment->recurring = true;
                $payment->agreement_id = date('ymd') . Str::random(9);
            }
            $CM_response = $payment->CustomMerchantPurchase($request->all(), $donor); // custom merchant
            $CM_response = json_decode($CM_response, true);
            // dd($CM_response);
            if (isset($CM_response['3ds_url']) && $CM_response['response_code'] == '20064') {
                $url = $CM_response['3ds_url'];
                return Redirect::to($url);
            }
            // elseif($CM_response['status'] == "00"){
            //     session()->flash('success' , $response['response_message'] ."fgfgfg" );
            //     return redirect()->route('site.checkout.show');
            // }
            else {
                $this->purchaseResponse($CM_response);
            }
        } else {
            session()->flash('warning', $response['response_message']);
            return redirect()->route('site.checkout.show', ['msg' => $response['response_message']]);
            // return redirect()->route('site.checkout.show');

        }
    }

    /**
     * purchase payfort and update status order
     *
     * @param Request $request
     *
     * @return [type]
     */
    public function purchaseResponse($response = null)
    {
        $response =  $response == null ? request()->all() : $response;
        
        unset($response['url'], $response['r'], $response['access_code'], $response['return_url'], $response['language'], $response['merchant_identifier']);
        $meta = json_encode($response);

        ($response['status'] == 14) ? $status = 1 : $status = 0;

        //load order data by merchant_reference/order_identifier
        $order = Order::find(getOrderId($response['merchant_reference']));
        if($order == null){
            $order = Order::find($response['merchant_reference']);
        }
        $donor = Donor::find($order?->donor_id);
        $card = CreditCard::where('merchant_reference', $response['merchant_reference'])->get()->first();


        if ($card) {
            @$card->status =  $status;
            @$card->save();
        }

        $order->payment_proof = $meta;
        $order->status = $status;
        $order->save();
        
        if ($status) {
            // if order detailes has project or more recarring using $this->hasRecurring or if has agreement_id

            // store new records in table called recarrings with the 12 record for each month and project on the same date with agreement_id
            //send Email and SMS confirmation
            Cookie::queue('cart', "");
            Cookie::queue(Cookie::forget('cart'));
            Cart::where('donor_id', $donor->id)->delete();
            session()->flash('success', __('Thank you for your donation through Nama'));
            return redirect()->route('site.checkout.success', $order->identifier);
            return view('site.pages.checkout.success', compact('order'));
        } else {
            return redirect()->route('site.checkout.show', ['msg' => $response['response_message']]);
        }
    }

    public function intital(Request $request)
    {
        $account = Accounts::find(1);
        $account->mobile = "055";
        $account->save();
    }


    /**
     * fast donation checkout payfort
     *
     * @param Request $request
     *
     * @return [type]
     */
    public function fastDonationPayfortIntital(Request $request)
    {
        $data = $request->all();

        //    if new card or selected saved card
        if (!isset($data['selected_card'])) {
            $card_data = [
                'card_number'               => $data['card_number'],
                'expiry_date'               => $data['expired_year'] . $data['expired_month'],
                'card_security_code'        => $data['cvv'],
                'card_holder_name'          => $data['card_name'],
            ];
        } else {
            $cardInfo = CreditCard::find(@$data['selected_card']);
            $card_data = [
                'card_number'           => (@$cardInfo->number),
                'expiry_date'           => decrypt(@$cardInfo->expired_year) . decrypt(@$cardInfo->expired_month),
                'card_security_code'    => $data['selected_cvv'],
                'card_holder_name'      => base64_decode(@$cardInfo->name),
            ];
        }

        //   Make th order in database
        $order = new CheckoutController();
        $orderData = $order->fastDonationProcess($data);

        //   if card is saved for feature purchase [it saves with status 0]
        if (@$data['savecard']) {
            $carddata = [
                'number'             => ($card_data['card_number']),
                'expired_month'      => encrypt($data['expired_month']),
                'expired_year'       => encrypt($data['expired_year']),
                'name'               => base64_encode($card_data['card_holder_name']),
                'donor_id'           => @auth()->user()->donor?->id,
                'merchant_reference' => $orderData['order']->identifier,
                'default'            => 1,
            ];

            CreditCard::create($carddata);
        }
        // call payfort Custom MerchantToken
        $payment = new PayfortCustomerMerchant();

        if ($this->testMode) {
            $redirectUrl = 'https://sbcheckout.payfort.com/FortAPI/paymentPage';
        } else {
            $redirectUrl = 'https://checkout.payfort.com/FortAPI/paymentPage';
        }

        $payment->return_url = route('api.payfort-intital');
        $payment->merchant_reference = 'AUTH3_' . $orderData['order']->identifier;
        $parameters = $payment->CustomMerchantToken($card_data);

        echo "<html xmlns='http://www.w3.org/1999/xhtml'>\n<head></head>\n<body>\n";
        echo '';
        echo '<div style="position:fixed; top:40%;right:50%;text-align: center;font-weight: bold;color: yellowgreen;" ><img src="' . site_path('img') . '/icon.gif"/>
            <p>   سيتم التحقيق من البينات </p></div>';
        echo "<form action='$redirectUrl' method='post' name='frm'>\n";
        foreach ($parameters as $a => $b) {
            echo "\t<input type='hidden' name='" . htmlentities($a) . "' value='" . htmlentities($b) . "'>\n";
        }
        echo "\t<script type='text/javascript'>\n";
        echo "\t\tdocument.frm.submit();\n";
        echo "\t</script>\n";
        echo "</form>\n</body>\n</html>";
    }



    /**
     * applepay
     *
     * @return [type]
     */
    public function applepay()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $customerIP = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $customerIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $customerIP = $_SERVER['REMOTE_ADDR'];
            }
            $order_id = $_POST['order_id'];
            $order = Order::find($order_id);
            $donor = Donor::find($order->donor_id);

            // if already called befor
            if ($order->status == 1) {
                session()->flash('success', trans("Pre-confirmed process"));
                return redirect(route('site.home'));
            }

            $apple_data = $_POST['apple_data']; //base64_encode($_POST['apple_data']);
            $apple_signature = $_POST['apple_signature']; //base64_encode($_POST['apple_signature']);
            $apple_transactionId = $_POST['apple_transactionId'];
            $apple_ephemeralPublicKey = $_POST['apple_ephemeralPublicKey']; //base64_encode($_POST['apple_ephemeralPublicKey']);
            $apple_publicKeyHash = $_POST['apple_publicKeyHash']; //base64_encode($_POST['apple_publicKeyHash']);
            $apple_displayName = $_POST['apple_displayName'];
            $apple_network = $_POST['apple_network'];
            $apple_type = $_POST['apple_type'];
            $amount = $_POST['amount'] * 100;
            if (empty($donor->email)) $donor->email = $donor->mobile . "@birrukum.org";
            // $merchant_reference = rand(0, getrandmax());
            $SHA_Request_Phrase = '82rJ.pmZVuyq1QaaTERA07@?';
            $arrData = array(
                'access_code' => 'nB4tY4pRnItey1PwrGCM',
                'amount' => $amount,
                'apple_data'            => $apple_data,
                'apple_signature'       => $apple_signature,
                'apple_header'          => [
                    'apple_transactionId' => $apple_transactionId,
                    'apple_ephemeralPublicKey' => $apple_ephemeralPublicKey,
                    'apple_publicKeyHash' => $apple_publicKeyHash,
                ],
                'apple_paymentMethod'   => [
                    'apple_displayName' => $apple_displayName,
                    'apple_network' => $apple_network,
                    'apple_type' => $apple_type,
                ],
                'command' => 'PURCHASE',
                'currency' => 'SAR',
                'customer_email' => @$donor->account?->email ?? $donor->mobile . '@birrukum.org',
                'customer_name' => $donor->full_name,
                'digital_wallet' => 'APPLE_PAY',
                'language' => 'en',
                'merchant_identifier' => 'BiZjlLxK',
                'merchant_reference' => $order->identifier,
                'order_description' => 'Package payment',
                'phone_number' => $donor->mobile,
                'customer_ip' => $customerIP,
                'return_url' =>  route('api.payfort-purchase'),

            );
            $shaString = '';
            ksort($arrData);
            foreach ($arrData as $key => $value) {
                if (is_array($value)) {
                    $shaSubString = '{';
                    foreach ($value as $k => $v) {
                        $shaSubString .= "$k=$v, ";
                    }
                    $shaSubString = substr($shaSubString, 0, -2) . '}';
                    $shaString .= "$key=$shaSubString";
                } else {
                    $shaString .= "$key=$value";
                }
            }
            $shaString = $SHA_Request_Phrase . $shaString . $SHA_Request_Phrase;
            $signature = hash('sha256', $shaString);
            $arrData['signature'] = $signature;
            $arrData = json_encode($arrData);

            $url = "https://paymentservices.payfort.com/FortAPI/paymentApi";
            // create a new cURL resource
            $ch = curl_init();
            $headers = array("Content-Type: application/json");
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arrData);
            $response = curl_exec($ch);
            if ($response === false) {
                echo '{"curlError":"' . curl_error($ch) . '"}';
            }
            curl_close($ch);

            $response = json_decode($response);
            unset($response['url'], $response['r'], $response['access_code'], $response['return_url'], $response['language'], $response['merchant_identifier']);
            $meta = json_encode($response);

            if ($response->status == 14) {
                $status = 1;
                // $sendData = [
                //     'mailto' => $donor->email,
                //     'mobile' => $donor->mobile,
                //     'identifier' => $order->order_identifier,
                //     'total' => $order->total,
                //     'project' => $order->projects,
                //     'donor' => $donor->full_name,
                //     'subject' => 'تم تسجيل تبرع جديد ',
                //     'msg' => "تم تسجيل تبرع جديد بمشروع : $order->projects  <br/> بقيمة : " . $order->total,
                // ];
                // send message sendConfirmation
                // send message of gift card
            } else {
                $status = 0;
            }

            //update order meta and status
            $order->payment_proof = $meta;
            $order->status = $status;
            $order->save();
            session()->flash('success', $response['response_message']);

            echo json_encode($response);
        } else {

            session()->flash('success', ' حدث خطأ ما ربما اتبعت رابط خاطيء ');
            return redirect(route('site.home'));
        }
    }

    /**
     * fined the order has project with recuring or not
     */
    private function hasRecurring($orderDetailes)
    {
        foreach ($orderDetailes as $detailes) {
            return ($detailes->project->recurring) ?  true : false;
        }
    }
}
