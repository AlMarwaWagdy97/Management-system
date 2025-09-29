<?php

namespace App\Charity\PaymentGateways;


interface PaymentInterface 
{

    public function convertAmount($amount, $currencyCode);

    public function getCurrencyDecimalPoints($currency);

    public function calculateSignature($requestData);

    public function process($requestData);

}