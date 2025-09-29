<?php

namespace App\Http\Livewire\Site\Carts;

use App\Models\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\Cookie;

class CartIcon extends Component
{
    public $cartQuantity;

    protected $listeners = ['cartUpdated'];

    public function cartUpdated()
    {
        $cookieValue = Cookie::get('cart');
        $this->cartQuantity = Cart::where('cookeries', $cookieValue)->sum('quantity');
    }

    public function render()
    {
        
        $cookieValue = Cookie::get('cart');
        $this->cartQuantity  = Cart::where('cookeries', $cookieValue)->sum('quantity');

        return view('livewire.site.carts.cart-icon');
    }
}
