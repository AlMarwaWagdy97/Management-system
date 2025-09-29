<?php

return [

    'DEBUG' => 'False',

    'PRODUCTION_CERTIFICATE_KEY'        => env('CERTIFICATE_KEY'),
    'PRODUCTION_CERTIFICATE_PATH'       => env('CERTIFICATE_PATH'),

    'PRODUCTION_CERTIFICATE_KEY_PASS'   => env('CERTIFICATE_KEY_PASS'),
    
    // 'PRODUCTION_MERCHANTIDENTIFIER'     => (openssl_x509_parse(file_get_contents(env('CERTIFICATE_PATH')))['subject']['UID']), //if you have a recent version of PHP, you can leave this line as-is. http://uk.php.net/openssl_x509_parse will parse your certificate and retrieve the relevant line of text from it e.g. merchant.com.name, merchant.com.mydomain or merchant.com.mydomain.shop
        
    'PRODUCTION_CURRENCYCODE'           => env('PRODUCTION_CURRENCYCODE'),
    'PRODUCTION_COUNTRYCODE'            => env('PRODUCTION_COUNTRYCODE'),
    'PRODUCTION_DISPLAYNAME'            => env('PRODUCTION_DISPLAYNAME'),
    'PRODUCTION_DOMAINNAME'             => env('APP_URL'),

   
];
