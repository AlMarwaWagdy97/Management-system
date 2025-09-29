<?php

namespace App\Http\Livewire\Site\Auth;

use App\Charity\Carts\DatabaseCart;
use App\Models\Donor;
use Livewire\Component;
use App\Models\Accounts;
use App\Models\LoginTypes;
use App\Charity\Notfications\SmsService;
use Illuminate\Support\Facades\Cookie;

class Register extends Component
{
    public $mobile = "", $name = "", $email = "", $identity = "", $otp = "";
    public $otpError = "", $authMessage = "", $authError = "", $otp_modal = false;
    public $sendOTP = "", $sendOTPExpirate = "", $mobileWithCode = "";

    public $showDescription1 = true;


    protected $listeners = ['register'];

    public $testMobiles = [
        "966597767751",
        "966567296308",
        "966561611117",
        "966540265614",
    ];

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'email' => 'email|string|email',
            'mobile' => 'required',
        ];
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function register($mobileCode)
    {
        $this->validate();

        $this->emptymessage();

        $mobile = str_replace("+", "", $mobileCode);
        // Check for existing mobile number in Donor model
        // $donor = Donor::where('mobile', $mobile)->first();
        // if ($donor != null) {
        //     return $this->authError = __('This mobile number is already registered.');
        // }

        // Check account table for existing mobile
        // $existingAccountByMobile = Accounts::where('mobile', $mobile)->first();
        // if ($existingAccountByMobile) {
        //     return $this->authError = __('This mobile number is already associated with an existing account.');
        // }

        // // --- NEW CHECK FOR EMAIL ---
        if ($this->email != "") {
            $existingAccountByEmail = Accounts::where('email', $this->email)->first();
            if (@$existingAccountByEmail->donor != null) {
                 $this->authError = __('This email is already in use. Please use a different email or log in.');
                 return;
            }
        }
        // --- END NEW CHECK ---

        // send SMS
        if (in_array($mobile, $this->testMobiles)) {
            $this->sendOTP = "1234";
        } else {
            $this->sendOTP = rand(1000, 9999);

            $message = "رمز التحقق : " . $this->sendOTP . "\n منصة يد ب يد\n " . route('site.home');

            if (substr($mobile, 0, 3) == "966") {
                $sms = new SmsService($mobile, $message);
                $sms = $sms->send();
            } else {
                $sms = new SmsService($mobile, $message);
                $sms = $sms->send();
            }
        }

        $this->sendOTPExpirate = time() + 600;
        $this->otp = "";
        $this->otp_modal = true;

        $this->mobileWithCode = $mobile;
    }

    public function checkOTP()
    {
        $this->emptymessage();

        if ($this->otp == "") {
            return $this->otpError = __('OTP is required');
        }
        if ($this->sendOTPExpirate < time()) {
            return $this->otpError = __('The OTP is expired');
        }
        if ($this->sendOTP != $this->otp) {
            return $this->otpError = __('The OTP is wrong');
        }

        $types = LoginTypes::query()->whereIn('type', ['donor'])->pluck('id')->toArray();

        // Create Account and Donor
        if($this->email == "") $this->email = null;
        
        $account = Accounts::where('mobile',  $this->mobileWithCode)->first();
        if ($account == null ) {
            $account = Accounts::create([
                'email' => $this->email,
                'mobile' => $this->mobileWithCode
            ]);
        }
        
       
        $account->types()->attach($types);

        $donor = Donor::with('account')->create([
            'account_id' => $account->id,
            'full_name' => $this->name,
            'mobile' => $this->mobileWithCode,
            'refer_id' => Cookie::get('referrer') ?? 1,
        ]);

        auth()->login($donor->account);
        $this->updateCart();
        $this->authMessage = __("You Registered Successfully");
        $this->otp_modal = false;
        $this->emit('authUpdated');
        $this->emit('updateCheckout');
        $this->emit('updateAuth');

        //     $this->emit('updateAuth');
        if (!$this->showDescription1 === false) {
            return redirect()->route('site.profile.index');
        }
  
    }

    public function updateCart()
    {
        $cart = new DatabaseCart();
        $cart->updateDonor();
    }

    public function closeModalOTP()
    {
        $this->otp_modal = false;
        $this->emptymessage();
    }

    public function emptymessage()
    {
        $this->authError = "";
        $this->otpError = "";
        $this->authMessage = "";
    }

    public function render()
    {
        return view('livewire.site.auth.register');
    }
}
