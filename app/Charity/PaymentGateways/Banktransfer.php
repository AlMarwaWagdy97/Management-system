<?php

namespace App\Charity\PaymentGateways;

use App\Charity\PaymentGateways\PaymentInterface;


class Banktransfer implements PaymentInterface
{

    public function convertAmount($amount, $currencyCode)
    {}

    public function getCurrencyDecimalPoints($currency){}

    public function calculateSignature($requestData){}

    public function process($requestData){}

    public function response($responsetData){}

    public function processOrderData($data){}
}