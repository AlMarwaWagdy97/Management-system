<?php

return [
    'payments' => [
        'banktransfer'      => 'App\Charity\PaymentGateways\ApplePay::class', 
        'applepay'          => 'App\Charity\PaymentGateways\ApplePay::class', 
        'payfortMerchant'   => 'App\Charity\PaymentGateways\PayfortCustomerMerchant::class', 
    ]
];