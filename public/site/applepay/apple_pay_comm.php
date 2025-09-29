<?php

	$validation_url = $_GET['u'];

	if( "https" == parse_url($validation_url, PHP_URL_SCHEME) && substr( parse_url($validation_url, PHP_URL_HOST), -10 )  == ".apple.com" ){

		require_once ('apple_pay_conf.php');

		// create a new cURL resource
		$ch = curl_init();

		$merchant = openssl_x509_parse(file_get_contents(asset( env('CERTIFICATE_PATH') ) )['subject']['UID']);

		$data = '{"merchantIdentifier":"'. $merchant .'", "domainName":"'.config('applepay.PRODUCTION_DOMAINNAME').'", "displayName":"'.config('applepay.PRODUCTION_DISPLAYNAME').'"}';

		curl_setopt($ch, CURLOPT_URL, $validation_url);

		curl_setopt($ch, CURLOPT_SSLCERT, asset(config('applepay.PRODUCTION_CERTIFICATE_PATH')));

		curl_setopt($ch, CURLOPT_SSLKEY, asset(config('applepay.PRODUCTION_CERTIFICATE_KEY')));

		curl_setopt($ch, CURLOPT_SSLKEYPASSWD, config('applepay.PRODUCTION_CERTIFICATE_KEY_PASS'));

		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);


		if(curl_exec($ch) === false)
		{
			echo '{"curlError":"' . curl_error($ch) . '"}';
		}

		// close cURL resource, and free up system resources
		curl_close($ch);
	}

?>