<?php

namespace App\Charity\PaymentGateways;


class ApplePay
{
    private $orderModel;
    public $donorModel;
    public $projectsModel;

    public function __construct()
    {
        // $this->orderModel = $this->model('Order');
        // $this->donorModel = $this->model('Donor');
        // $this->projectsModel = $this->model('Project');
    }

    public function index()
    {
        redirect('', true);
    }

    public function payfort()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(!empty($_SERVER['HTTP_CLIENT_IP'])){
                $customerIP = $_SERVER['HTTP_CLIENT_IP'];
            }
            elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $customerIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else{
                $customerIP = $_SERVER['REMOTE_ADDR'];
            }
            $order_id = $_POST['order_id'];
            $order = $this->orderModel->getOrderById($order_id);
            $donor = $this->donorModel->getDonorId($order->donor_id);
            $apple_data = $_POST['apple_data']; //base64_encode($_POST['apple_data']);
            $apple_signature = $_POST['apple_signature']; //base64_encode($_POST['apple_signature']);
            $apple_transactionId = $_POST['apple_transactionId'];
            $apple_ephemeralPublicKey = $_POST['apple_ephemeralPublicKey']; //base64_encode($_POST['apple_ephemeralPublicKey']);
            $apple_publicKeyHash = $_POST['apple_publicKeyHash']; //base64_encode($_POST['apple_publicKeyHash']);
            $apple_displayName = $_POST['apple_displayName'];
            $apple_network = $_POST['apple_network'];
            $apple_type = $_POST['apple_type'];
            $amount = $_POST['amount'] * 100;
            if (empty($donor->email)) $donor->email = "test@test.com";
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
                'customer_email' => $donor->email,
                'customer_name' => $donor->full_name,
                'digital_wallet' => 'APPLE_PAY',
                'language' => 'en',
                'merchant_identifier' => 'BiZjlLxK',
                'merchant_reference' => $order->order_identifier,
                'order_description' => 'Package payment',
                'phone_number' => $donor->mobile,
                'customer_ip' => $customerIP,
                // 'return_url' => 'https://birrukum.org/test/respond?r=processResponse',
                'return_url' => 'https://birrukum.org/projects/payfortrespond?r=processResponse',

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
            }        // close cURL resource, and free up system resources
            curl_close($ch);
            // $return_response = json_encode($response);
            //update order meta
            //updating donation status in donation table
            $response_obj = json_decode($response);
            if ($response_obj->status == 14) {
                $status = 1;
                $sendData = [
                    'mailto' => $donor->email,
                    'mobile' => $donor->mobile,
                    'identifier' => $order->order_identifier,
                    'total' => $order->total,
                    'project' => $order->projects,
                    'donor' => $donor->full_name,
                    'subject' => 'تم تسجيل تبرع جديد ',
                    'msg' => "تم تسجيل تبرع جديد بمشروع : $order->projects  <br/> بقيمة : " . $order->total,
                ];
                // $messaging = $this->model('Messaging');
                // $messaging->sendConfirmation($sendData);
                // $messaging->sendGiftCard($order); // send message of gift card
            } else {
                $status = 0;
            }
            $data = [
                'meta' => $response,
                'hash' => $order->hash,
                'status' => $status,
            ];
            $this->projectsModel->updateDonationStatus($order->order_id, $status);
            $this->projectsModel->updateOrderMeta($data); //update donation meta and set status on order table


            //update order status
            echo json_encode($response);
        } else {
            // flashRedirect('', 'msg', 'حدث خطأ ما ربما اتبعت رابط خاطيء ', 'alert alert-danger');
        }
    }
}
