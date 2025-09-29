<?php

namespace App\Http\Livewire\Site\Vendor;

use App\Models\Accounts;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Login extends Component
{

    public $email = "", $password, $errorMessage;


    protected function rules(){
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    /**
     * vendor login by email & password
     */
    public function login(){
        $data = $this->validate();
        $this->emptymessage();

        $vendor = Accounts::where('email', $this->email)->get()->first();
        if($vendor->vendor == null || $vendor->types?->where('type', 'vendor')->first() == null){
            return $this->errorMessage = trans('Wrong email & password');
        }
        if (!Hash::check($this->password, $vendor->password)) {
           return  $this->errorMessage = trans('Incorrect password');
        }
        if(@$vendor->vendor->status != 1){
           return  $this->errorMessage = trans('Your account is inactive');
        }
        Auth::login($vendor); 
        $this->emit('authUpdated');
        return redirect()->route('site.vendors.index');
    }

    /**
     * emprty error message 
     */
    public function emptymessage(){
        $this->errorMessage = "";
    }

    public function render()
    {
        return view('livewire.site.vendor.login');
    }
}
