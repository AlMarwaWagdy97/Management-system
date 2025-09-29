<?php

return [
    'url' => env('url', "https://sbpaymentservices.payfort.com/FortAPI/paymentApi"),
    'mechant_identifier' => env('PAYFORT_MERCHANT_IDENTIFIER', "41b42b4b"),
    'access_code' => env('PAYFORT_ACESS_CODE', "5GjnXYbP9Mk1ExYud4Np"),
    'SHARequestPhrase' => env('PAYFORT_SHAR_REQUEST_PHARSE', "737LIJbY2e1b5sTd0.8iPE+_"),
    'SHAResponsePhrase' => env('PAYFORT_SHAR_RESPONSE_PHRASE', "40XXl7OkhQg3kHcxiuUSDl!-"),



    // 'gateway_host' => env('PAYFORT_GATEWAY_HOST', 'https://checkout.payfort.com/'),
    // 'gateway_sandbox_host' => env('PAYFORT_GATEWAY_SAND_BOX_HOST', 'https://sbcheckout.payfort.com/'),

    // 'merchants' => [
    //     'merchant_identifier' => env('PAYFORT_MERCHANT_IDENTIFIER', null),
    //     'access_code' => env('PAYFORT_ACESS_CODE', null),
    //     'SHA_request_phrase' => env('PAYFORT_SHAR_REQUEST_PHARSE', null),
    //     'SHA_response_phrase' => env('PAYFORT_SHAR_RESPONSE_PHRASE', null),
    // ],

    // 'sandbox_mode' => env('PAYFORT_SANDBOX_MODE', true),
    // 'SHA_type' => env('PAYFORT_SHA_TYPE', 'sha256'),
    // 'language' => env('PAYFORT_LANGUAGE', 'ar'),
];