<?php

namespace App\Http\Controllers\Site;

use App\Charity\PaymentGateways\PayfortCustomerMerchant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Profile\CreditCardsRequest;
use App\Models\CreditCard;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProfileCardsController extends Controller
{

    public $testMode = true;

    public function __construct()
    {
        $this->testMode = config('app.TEST_MODE');
    }

    /**
     * Display the profile cards view.
     *
     * @return \Illuminate\View\View The profile cards view.
     */
    public function index()
    {
        $creditCards = CreditCard::active()->where('donor_id', auth('account')->user()->donor->id)->get();
        return view('site.profile.cards.index', compact('creditCards'));
    }

    /**
     * Display the profile cards add.
     *
     * @return \Illuminate\View\View The profile cards view.
     */
    public function add()
    {
        return view('site.profile.cards.add');
    }


    /**
     * DELETE the profile cards .
     *
     * @return \Illuminate\View\View The profile cards view.
     */
    public function delete($id)
    {
        $card = CreditCard::find($id);
        $card->delete();
        session()->flash('success', trans('The card has been removed successfully.'));
        return redirect(route('site.profile.cards.index'));
    }
    /**
     * save the cards.
     *
     * @return \Illuminate\View\View The profile cards view.
     */
    public function save(CreditCardsRequest $request)
    {
        $data = $request->validated();
        $savedCard = $this->saveCardInfo($data);

        $cardInfo['card_number'] = $data['number'];
        $cardInfo['expiry_date'] = $data['expired_year'] . $data['expired_month'];
        $cardInfo['card_security_code'] = $data['cvv'];
        $cardInfo['card_holder_name'] = $data['name'];

        if ($this->testMode) {
            $redirectUrl = 'https://sbcheckout.payfort.com/FortAPI/paymentPage';
        } else {
            $redirectUrl = 'https://checkout.payfort.com/FortAPI/paymentPage';
        }

        $payment = new PayfortCustomerMerchant();
        $payment->return_url = route('api.profile.cards.payfortrespondSaveCard');
        $payment->merchant_reference = 'CARD_' . $savedCard->id;
        $parameters = $payment->CustomMerchantToken($cardInfo);

        if ($this->testMode) {
            $redirectUrl = 'https://sbcheckout.payfort.com/FortAPI/paymentPage';
        } else {
            $redirectUrl = 'https://checkout.payfort.com/FortAPI/paymentPage';
        }

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


    public function saveCardInfo($data)
    {
        $carddata['donor_id']               =  auth('account')->user()->donor->id;
        $carddata['number']                 = ($data['number']);
        $carddata['expired_month']          = encrypt($data['expired_month']);
        $carddata['expired_year']           = encrypt($data['expired_year']);
        $carddata['name']                   = base64_encode($data['name']);
        return CreditCard::create($carddata);
    }


    public function payfortrespondSaveCard(Request $request)
    {
        $response = $request->all();
        ($response['status'] == 18) ? $status = 1 : $status = 0;
        if ($status == 1) {
            $card_info = CreditCard::find((str_replace('CARD_', '', $response['merchant_reference'])));
            $card_info->status = 1;
            $card_info->token_name = $response['token_name'];
            $card_info->save();
            // if donor have same card will updated
            $sameCard = CreditCard::where('donor_id', $card_info->donor_id)->where('number', $card_info->number)->where('id', '!=', $card_info->id)->get();
            if (count($sameCard)) {
                foreach ($sameCard as $card)
                    $card->delete();
            }
            session()->flash('success', trans('The card has been saved successfully.'));
            return redirect(route('site.profile.cards.add'));
        } else {
            session()->flash('warning', $response['response_message'] ?? "Error");
            return redirect(route('site.profile.cards.add'));
        }
    }
}
