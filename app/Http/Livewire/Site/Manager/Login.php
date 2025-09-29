<?php

namespace App\Http\Livewire\Site\Manager;

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

        $manager = Accounts::where('email', $this->email)->get()->first();
        if($manager->manager == null || $manager->types?->where('type', 'manager')->first() == null){
            return $this->errorMessage = trans('Wrong email & password');
        }
        if (!Hash::check($this->password, $manager->password)) {
           return  $this->errorMessage = trans('Incorrect password');
        }
        if(@$manager->manager->status != 1){
           return  $this->errorMessage = trans('Your account is inactive');
        }
        Auth::login($manager); 
        $this->emit('authUpdated');
        return redirect()->route('site.managers.index');
    }

    /**
     * emprty error message 
     */
    public function emptymessage(){
        $this->errorMessage = "";
    }
    public function render()
    {
        return view('livewire.site.manager.login');
    }
}
