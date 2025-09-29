<?php

namespace App\Http\Livewire\Site\Home;

use App\Charity\Carts\DatabaseCart;
use App\Charity\Carts\Item;
use App\Models\Product;
use Livewire\Component;

class Products extends Component
{
    public $product;
    public $msg = [];

    public $donationAmt,  $donationtype = "Gift Product", $donationQty = 1; // cart info 


    public function mount($product)
    {
        // define projects data
        $this->product = $product;
        $this->product['slug'] = $this->product['trans'][0]['slug'];
        $this->product['title'] = $this->product['trans'][0]['title'];
        $this->product['description'] = $this->product['trans'][0]['description'];

        $this->donationAmt = $this->product['price'];
    }

    public function addToCart()
    {
        $this->clear();
        $item = new Item(Product::class, $this->product['id'], $this->donationtype); // create item data
        // add to card 
        $cart = new DatabaseCart();
        $this->msg = $cart->addItem($item, $this->donationQty, $this->donationAmt, Null, true);
        // update in cart item 
        $this->emit('cartUpdated');
        // show model
        if ($this->msg['type'] == "success") {
            $this->emit('showModel', __('The gift has been added to the cart'));
        }
    }

    public function clear()
    {
        $this->msg = [];
    }

    public function render()
    {
        return view('livewire.site.home.products');
    }
}
