<?php

namespace App\Charity\PaymentGateways;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;


class PayfortCustomerMerchant
{

    public $testMode = true;

    public $mechant_identifier = "";
    public $access_code        = "";
    public $SHARequestPhrase   = "";
    public $SHAResponsePhrase  = "";
    public $url                = "";
    public $amount             = 100;
    public $currency           = 'SAR';
    public $language           = 'ar';
    public $return_url         = '/';
    public $merchant_reference = '';
    public $order_description  = '';
    public $paymentMethod      = '';
    public $recurring          = false;
    public $agreement_id;

    public function __construct()
    {
        $this->testMode = config('app.TEST_MODE');
    }


    public function defineVariables()
    {
        if ($this->testMode) {
            $this->url = "https://sbpaymentservices.payfort.com/FortAPI/paymentApi";
            $this->mechant_identifier = "9cc5d3c5";
            $this->access_code = "lR3miH0aJZTNBCW5So7m";
            $this->SHARequestPhrase = "96o0CiKlNkSJO7/OJH8ALl$+";
            $this->SHAResponsePhrase =  "19LyOVjIq9cJDej0PQ.lNO{@";
        } else {
            $this->url = 'https://paymentservices.payfort.com/FortAPI/paymentApi';
            $this->mechant_identifier = config("payfort.mechant_identifier");
            $this->access_code = config("payfort.access_code");
            $this->SHARequestPhrase = config("payfort.SHARequestPhrase");
            $this->SHAResponsePhrase = config("payfort.SHAResponsePhrase");
        }
    }

    /**
     * Convert Amount with dicemal points
     * @param decimal $amount
     * @param string  $currencyCode
     * @return decimal
     */
    public function convertAmount($amount, $currencyCode)
    {
        $new_amount = 0;
        $total = $amount;
        $decimalPoints = $this->getCurrencyDecimalPoints($currencyCode);
        $new_amount = round((float)$total, (float)$decimalPoints) * (pow(10, $decimalPoints));
        return $new_amount ?? 0;
    }


    /**
     *
     * @param string $currency
     * @param integer
     */
    public function getCurrencyDecimalPoints($currency)
    {
        $decimalPoint = 2;
        $arrCurrencies = array(
            'JOD' => 3,
            'KWD' => 3,
            'OMR' => 3,
            'TND' => 3,
            'BHD' => 3,
            'LYD' => 3,
            'IQD' => 3,
        );
        if (isset($arrCurrencies[$currency])) {
            $decimalPoint = $arrCurrencies[$currency];
        }
        return $decimalPoint;
    }

    public function calculateSignature($requestData)
    {
        $shaString  = '';
        ksort($requestData);
        foreach ($requestData as $k => $v) {
            $shaString .= "$k=$v";
        }
        $shaString = $this->SHARequestPhrase . $shaString . $this->SHARequestPhrase;
        $signature = hash('sha256', $shaString);
        return  $signature;
    }



    public function CustomMerchantToken($cardInfo)
    {
        $this->defineVariables();
        $requestParams = [
            'service_command'         => 'TOKENIZATION',
            'language'                => $this->language,
            'merchant_identifier'     => $this->mechant_identifier,
            'access_code'             => $this->access_code,
            'return_url'              => $this->return_url,
            'merchant_reference'      => $this->merchant_reference,
        ];
        $signature = $this->calculateSignature($requestParams);
        $requestParams['signature'] = $signature;
        $requestParams['card_number'] = $cardInfo['card_number'];
        $requestParams['expiry_date'] = $cardInfo['expiry_date'];
        $requestParams['card_security_code'] = $cardInfo['card_security_code'];
        $requestParams['card_holder_name'] = $cardInfo['card_holder_name'];
        return $requestParams;
    }

    public function CustomMerchantPurchase($fortParams, $donor)
    {
        $this->defineVariables();
        $data = [
            'command'               => 'PURCHASE',
            "access_code"           => $this->access_code,
            "merchant_identifier"   => $fortParams['merchant_identifier'],
            'merchant_reference'    => $this->merchant_reference,
            'language'              => $this->language,
            'amount'                => $this->convertAmount($this->amount, $this->currency),
            'currency'              => $this->currency,
            'customer_email'        => @$donor->email ?? 'almarwa.wagdy@gmail.com',
            'customer_ip'           => $_SERVER['REMOTE_ADDR'],
            'customer_name'         => @$donor->full_name ?? "AlMarwa Wagdy ElMonshed",
            'token_name'            => $fortParams['token_name'],
            'return_url'            => $this->return_url,
            'order_description'     => str_replace(',', ' - ', $this->order_description ?? "cart"),
        ];


        if ($this->paymentMethod == 'sadad') {
            $data['payment_option'] = 'SADAD';
        } elseif ($this->paymentMethod  == 'naps') {
            $data['payment_option'] = 'NAPS';
            $data['order_description'] = $this->order_description;
        } elseif ($this->paymentMethod  == 'installments') {
            $data['installments'] = 'STANDALONE';
        } elseif ($this->paymentMethod == 'STCPAY') {
            $data['digital_wallet'] = 'STCPAY';
        }
        // if the project accept Monthly deduction
        if ($this->recurring) {
            $data['eci'] = 'RECURRING';
            $data['agreement_id'] = $this->agreement_id;
            $data['recurring_mode'] = "UNSCHEDULED";
        }

        $data['signature'] = $this->calculateSignature($data);
        // $data = ['key' => 'value']; // Replace with your JSON data
        $response = Http::withHeaders(['Content-Type' => 'application/json'])->post($this->url, $data);

        $result = $response->body();


        return $result;
    }
}
