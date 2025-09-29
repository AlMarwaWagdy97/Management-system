<?php

namespace App\Http\Livewire\Site\Auth;

use App\Charity\Carts\DatabaseCart;
use App\Models\Donor;
use Livewire\Component;
use App\Charity\Notfications\SmsService;
use Illuminate\Support\Facades\Cookie;


class Login extends Component
{
    public $mobile = "", $donor;
    public $otpError = "", $authMessage = "", $authError = "", $otp_modal = "";
    public $sendOTPExpirate = "", $otp, $sendOTP = "", $mobileWithCode = "";
    public $showDescription = true;
    public $register_modal = false, $registerMessage = "";

    protected $listeners = ['login'];

    public $countryCode = '966';

    public $testMobiles = [
        "966597767751",
        "966567296308",
        // "966561611117",
        "966540265614",
    ];

    protected function rules()
    {
        return [
            
            'mobile' => 'nullable', 
        ];
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function login($mobileCode)
    {
        $this->validate();
        
        $this->emptymessage();  
        $mobile = str_replace("+", "", $mobileCode);
        
        $donor = Donor::with('account')->where('mobile', $mobile)->get()->first();
        
        if ($donor == null) {
            // return $this->authError = __('This number is not registered with us');
            $this->registerMessage = __('This number is not registered with us please register now');
            return $this->register_modal = true;
        }

        if (in_array($mobile, $this->testMobiles)) {
            $this->sendOTP = "1234";
        } else {
            $this->sendOTP = rand(1000, 9999);

            $message = "رمز التحقق : " . $this->sendOTP . "\n منصة يد ب يد\n " . route('site.home') ;

            if (substr($mobile, 0, 3) == "966") {
                $sms = new SmsService($mobile, $message);
                $sms = $sms->send();
            } else {
                $sms = new SmsService($mobile,$message);
                $sms = $sms->send();
            }
        }
        
        $donor->otp = $this->sendOTP;
        $this->sendOTPExpirate = time() + 600;
        $donor->expiration = time() + 600; 
        $donor->save();
        
        $this->otp = "";
        $this->otp_modal = true;
        $this->donor = $donor;
        $this->mobileWithCode = $mobile;
        
    }

    public function checkOTP()
    {
        $this->emptymessage();
        
        if ($this->otp == "") {
            return $this->otpError = __('OTP is required');
        }
        
        $donor = Donor::with('account', 'account.types')->where('mobile', $this->mobileWithCode)->get()->first();
        
        if ($this->sendOTPExpirate < time()) {
            return $this->otpError = __('The OTP is expired');
        }
        
        if (@$this->otp != strval($donor->otp)) {
            return $this->otpError = __('The OTP is wrong');
        }
        
        if ($donor->account->types->where('type', 'donor')->first() == null) {
            $this->otp_modal = false;
            return $this->authError = __('This number is not registered with us');
        }
        
        if ($donor->refer_id == null) {
            $donor->refer_id = Cookie::get('referrer') ?? 1;
            $donor->save();
        }

        auth()->login($donor->account);
        $this->updateCart();
        $this->authMessage = __("You Loggin Sucessfully");
        $this->otp_modal = false;
        $this->emit('authUpdated');
        $this->emit('updateCheckout');
        $this->emit('updateAuth');

    //     $this->emit('updateAuth');
        if (!$this->showDescription === false) {
            return redirect()->route('site.profile.index');
        }
    }

    public function updateCart()
    {
        $cart = new DatabaseCart();
        $cart->updateDonor();
    }

    public function emptymessage()
    {
        $this->authError = "";
        $this->otpError = "";
        $this->authMessage = "";
    }

    public function closeModalOTP()
    {
        $this->otp_modal = false;
    }
    public function closeRegisterModalOTP()
    {
        $this->register_modal = false;
    }

    public function render()
    {
        return view('livewire.site.auth.login');
    }
}