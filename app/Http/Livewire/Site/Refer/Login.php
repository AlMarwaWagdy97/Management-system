<?php

namespace App\Http\Livewire\Site\Refer;

use App\Models\Accounts;
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

        $refer = Accounts::where('email', $this->email)->get()->first();
        if($refer->referer == null || $refer->types?->where('type', 'refer')->first() == null){
            return $this->errorMessage = trans('Wrong email & password');
        }
        if (!Hash::check($this->password, $refer->password)) {
           return  $this->errorMessage = trans('Incorrect password');
        }
        if(@$refer->referer->status != 1){
           return  $this->errorMessage = trans('Your account is inactive');
        }
        Auth::login($refer); 
        $this->emit('authUpdated');
        return redirect()->route('site.referer.index');
    }

    /**
     * emprty error message 
     */
    public function emptymessage(){
        $this->errorMessage = "";
    }

    public function render()
    {
        return view('livewire.site.refer.login');
    }
}


