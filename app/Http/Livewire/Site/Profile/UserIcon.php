<?php

namespace App\Http\Livewire\Site\Profile;

use App\Models\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\Cookie;

class UserIcon extends Component
{
    public $user = null;

    protected $listeners = ['authUpdated'];

    public function authUpdated(){
        $this->user = auth()->user();

        $cookieValue = Cookie::get('cart');
        $carts = Cart::where('cookeries', $cookieValue)->get();
        if(auth('account')->user()?->types->where('type', 'donor')->first()){
            foreach ($carts as $cart) {
                $cart->donor_id = auth('account')->user()->donor->id;
                $cart->save();
            }
        }
    }


    public function render()
    {
        $this->user = auth('account')->user()?->donor;
        if($this->user == null) $this->user =  auth('account')->user()?->referer;
        if($this->user == null) $this->user =  auth('account')->user()?->manager;
        return view('livewire.site.profile.user-icon');
    }
}
