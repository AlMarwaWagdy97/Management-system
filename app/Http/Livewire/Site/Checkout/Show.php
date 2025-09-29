<?php

namespace App\Http\Livewire\Site\Checkout;

use Livewire\Component;
use App\Charity\Carts\DatabaseCart;
use App\Charity\Gifts\Given;

class Show extends Component
{
    public $items = [], $total = 0;
    protected $cart;
    public $cardFields = [], $giftError, $showModal = [];

    public $listeners = ['openModal', 'updateCheckout'];


    public function __construct()
    {
        $this->cart = new DatabaseCart();
    }

    public function saveGiftInfo($cart_id){

        if(@$this->cardFields[$cart_id]['giver_name'] == "" || @$this->cardFields[$cart_id]['giver_mobile'] == "" ||
            @$this->cardFields[$cart_id]['giver_address'] == ""  ){
            return $this->giftError = __('Please enter all fields');
        }
        $this->dispatchBrowserEvent('closemodal', $cart_id);
        $this->emit('closemodal', "$cart_id");
        
        // get json Gift card details
        $cart = new DatabaseCart();
        $givenDetails = new Given($this->cardFields[$cart_id]);
        $cart->addGivtenCard($cart_id, $givenDetails->getData());

        return 0;
    }

    public function openModal($id){
        $this->showModal[$id] = true;
    }

    public function closeModal($id){
        $this->showModal[$id] = false;
        $this->dispatchBrowserEvent('closemodal', "$id");
    }


    public function updateCheckout(){
        $this->render();
    }


    public function render()
    {
        $this->items =  $this->cart->getItems();
        return view('livewire.site.checkout.show');
    }
}
