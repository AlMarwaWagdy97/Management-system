<?php

namespace App\Charity\Notfications;

use App\Charity\Settings\SettingSingleton;
use Illuminate\Support\Facades\Http;

class SmsService
{

    /**
     * The number to which the SMS will be sent .
     * @var string
     */
    protected $mobile;

    /**
     * msg send in sms
     * @var string
     */
    protected $msg;

    /**
     * SMS constructor.
     *
     * @param string $mobile
     * @param string $msg
     */
    public function __construct($mobile, $msg)
    {
        $this->mobile = $mobile;
        $this->msg = $msg;
    }

    /**
     *
     *  send SMS
     */
    public function send()
    {
        $settings = SettingSingleton::getInstance();
        $gateurl = $settings->getExternalConnectionData('sms_gateurl');
        $username = $settings->getExternalConnectionData('sms_sender_name');
        $password = $settings->getExternalConnectionData('sms_password');
        $url = $gateurl . '?bearerTokens=' . urlencode( $password) . '&sender=' . urlencode($username) . '&recipients=' . urlencode($this->mobile) . '&body=' . urlencode($this->msg); // built url
        $response = Http::get($url);
        return $response->body();
    }

    public function sendForRegister($request)
    {
        $settings = SettingSingleton::getInstance();
        $gateurl = $settings->getExternalConnectionData('sms_gateurl');
        $username = $settings->getExternalConnectionData('sms_sender_name');
        $password = $settings->getExternalConnectionData('sms_password');
        $url = $gateurl . '?bearerTokens=' . urlencode( $password) . '&sender=' . urlencode($username) . '&recipients=' . urlencode($this->mobile) . '&body=' . urlencode($this->msg); // built url
        $response = Http::get($url);
        return $response->body();
    }

}