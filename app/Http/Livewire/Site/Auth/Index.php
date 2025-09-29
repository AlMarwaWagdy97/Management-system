<?php

namespace App\Http\Livewire\Site\Auth;

use App\Charity\Carts\DatabaseCart;
use App\Models\Donor;
use Livewire\Component;
use App\Models\Accounts;
use App\Models\LoginTypes;
use App\Charity\Notfications\SmsService;
use App\Charity\Settings\SettingSingleton;
use Illuminate\Support\Facades\Cookie;

class Index extends Component
{
    public $new_donor = false, $otp_modal = false, $sendOTP = "", $sendOTPExpirate = "";
    public $mobile = "", $name = "", $email = "", $otp = "";
    public $authError = "", $otpError = "", $mobileWithCode = "";
    public $authMessage = "", $show_auth = true, $otp_status =  true;
    public $type, $donor;

    protected $listeners = ['login', 'register'];

    public function emptymessage()
    {
        $this->authError  = "";
        $this->otpError   = "";
        $this->authMessage = "";
    }


    public $testMobiles = [
        "966597767751",
        "966567296308",
        "966561611117",
        "966540265614",
        "966561611119",
    ];
    protected function rules()
    {
        if ($this->new_donor) {
            return [
                'name' => 'required|string|min:3',
                'email' => 'email|string|email',
                'mobile' => 'required',
            ];
        } else {
            return [
                'mobile' => 'required',
            ];
        }
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }


    public function updateNewDonor($val)
    {
        $this->emptymessage();
        $this->mobile = "";
        $this->name   = "";
        $this->email  = "";
        $this->otp    = "";
        $this->new_donor = $val;
    }

    public function login($mobileCode)
    {
        $this->validate();

        $this->donor = "";

        $this->emptymessage();
        $mobile = str_replace("+", "", $mobileCode);

        $donor = Donor::with('account')->where('mobile', $mobile)->get()->first();

        if ($donor == null) {
            $this->authError = __('This number is not registered with us please register first');
            $this->new_donor = 1; 
            return;
        }

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
        if ($this->sendOTPExpirate < time()) {
            return $this->otpError = __('The OTP is expired');
        }
        if ($this->sendOTP != $this->otp) {
            return $this->otpError = __('The OTP is wrong');
        }

        if (!$this->new_donor) {

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
            $this->authMessage = __("You Loggin Sucessfully");

        } else {

            $types = LoginTypes::query()->whereIn('type', ['donor'])->pluck('id')->toArray();

            // Create Account and Donor
            if($this->email == "") $this->email = null;
            $account = Accounts::where('mobile',  $this->mobileWithCode)->first();
            if ($account == null ) {
                $account = Accounts::create([
                    'email' => $this->email ?? Null,
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
            $this->authMessage = __("You Registered Successfully");
        }

        auth()->login($donor->account);
        // $this->updateCart();
        $this->otp_modal = false;
        $this->emit('authUpdated');
        $this->emit('updateCheckout');
        $this->emit('updateAuth');
    }



    public function register($mobileCode)
    {
        $this->validate();

        $this->emptymessage();

        $mobile = str_replace("+", "", $mobileCode);
        // Check for existing mobile number in Donor model
        $donor = Donor::where('mobile', $mobile)->first();
        if ($donor != null) {
            return $this->authError = __('This mobile number is already registered.');
        }

        // Check account table for existing mobile
        // $existingAccountByMobile = Accounts::where('mobile', $mobile)->first();
        // if ($existingAccountByMobile) {
        //     return $this->authError = __('This mobile number is already associated with an existing account.');
        // }

        // // --- NEW CHECK FOR EMAIL ---
        if ($this->email != "") {
            $existingAccountByEmail = Accounts::where('email', $this->email)->first();
            if (@$existingAccountByEmail->donor != null) {
                return $this->authError = __('This email is already in use. Please use a different email or log in.');
            }
        }
        // --- END NEW CHECK ---

        // send SMS
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

        $this->sendOTPExpirate = time() + 600;
        $this->otp = "";
        $this->otp_modal = true;

        $this->mobileWithCode = $mobile;
    }



    public function LoginWithOutOtp(){
        if(!$this->new_donor){
            $donor = Donor::with('account', 'account.types')->where('mobile', $this->mobile)->get()->first();
            if($donor->account->types->where('type', 'donor')->first() == null){
                return $this->authError = __('This number is not registered with us'); 
            }
        }else{
            $account = Accounts::create(['email' => $this->email, 'mobile' => $this->mobile]);
            $types = LoginTypes::query()->whereIn('type', ['donor'])->pluck('id')->toArray();
            $account->types()->attach($types);
            $donor = Donor::with('account')->create([
                'account_id' => $account->id,
                'full_name' => $this->name,
                'mobile' => $this->mobile,
            ]);
        }
        auth()->login($donor->account);
        $this->updateCart();
        $this->authMessage = __("You Loggin Sucessfully");
        $this->otp_modal = false;
        $this->emit('authUpdated');
        $this->emit('updateAuth');
    }

    public function closeModalOTP(){
        $this->otp_modal = false;
    }




    // public function updateCart(){
    //     $cart = new DatabaseCart(); 
    //     $cart->updateDonor();
    // }
    public function updateCheckout()
    {
        $this->render();
    }
    public function mount($type)
    {
        $this->show_auth = SettingSingleton::getInstance()->getLoginStatus('show_login_' . $type) ?? 1;
        $this->otp_status = SettingSingleton::getInstance()->getLoginStatus('send_otp_' . $type) ?? 1;
    }
    public function render()
    {
        // @auth('account')->user();
        // @auth('account')->logout();
        // dd(@auth('account')->user());

        return view('livewire.site.auth.index');
    }
}
