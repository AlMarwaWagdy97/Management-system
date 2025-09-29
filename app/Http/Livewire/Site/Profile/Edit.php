<?php

namespace App\Http\Livewire\Site\Profile;

use App\Charity\Notfications\SmsService;
use Livewire\Component;

class Edit extends Component
{

    public $donor, $sendOTP;
    public $full_name, $email, $mobile = "";
    public $otpError = "", $authMessage = "", $authError = "", $otp_modal = "";

    public $testMobiles = [
        "597767751",
        "567296308",
        "561611117",
        "540265614",
    ];


    protected function rules(){
        return [
            'full_name' => 'required|min:3|string',
            'mobile' => 'required|min:9|max:9',
            'email' => 'required|min:3|email',
        ];
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function updateProfile(){
        $this->emptymessage();
        $this->validate();
        if(in_array($this->mobile, $this->testMobiles)){
            $this->sendOTP = "1234";
        }
        else{
            $this->sendOTP = rand(1000, 9999);
            // Send OTP in SMS 
            $message = "رمز التحقق : " . $this->sendOTP . "\n منصة يد ب يد\n " . route('site.home') ;
            $sms = new SmsService($this->mobile, $message);
            $sms = $sms->send();
        }
        $this->donor->otp = $this->sendOTP ;
        $this->donor->expiration = time() + 600;
        $this->donor->save();
        $this->otp = "";
        $this->otp_modal = true;
    }


    public function checkOTP(){
        $this->emptymessage();
        if($this->otp ==""){
            return $this->otpError = __('OTP is required');
        }
        if(@$this->donor->expiration < time() ){ return $this->otpError = __('The OTP is expired');  }
        if(@$this->otp != strval($this->donor->otp)){ return $this->otpError = __('The OTP is wrong'); }
        $this->donor->update(['full_name' => $this->full_name]);
        $this->donor->account->update(['email' => $this->email, 'mobile' => $this->mobile]);

        $this->otp_modal = false;
        $this->emit('authUpdated');
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->route('site.profile.index');

    }

    public function emptymessage(){
        $this->authError = "";
        $this->otpError = "";
        $this->authMessage = "";
    }

    public function closeModalOTP(){
        $this->otp_modal = false;
    }



    public function mount(){
        $this->donor = auth('account')->user()->donor;
        $this->full_name = $this->donor->full_name;
        $this->email = $this->donor->account->email;
        $this->mobile = $this->donor->mobile;
    }

    public function render()
    {
        return view('livewire.site.profile.edit');
    }
}
