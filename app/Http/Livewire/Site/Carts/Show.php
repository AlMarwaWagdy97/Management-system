<?php

namespace App\Http\Livewire\Site\Carts;

use Livewire\Component;
use App\Charity\Carts\DatabaseCart;
use App\Charity\Gifts\Given;

class Show extends Component
{
    public $items = [], $total = 0;
    public $cardFields = [], $giftError, $showModal = [];

    protected $cart;

   
    public function __construct()
    {
        $this->cart = new DatabaseCart();
    }

    /**
     * rules validation
     */
    protected function rules()
    {
        $rules =  [
            'cardFields.*.giver_name' => 'required|string',
            'cardFields.*.giver_mobile' => 'nullable|digits:9', 
            'cardFields.*.giver_address' => 'required|string',
            'cardFields.*.giver_message' => 'nullable|string',
        ];
        return $rules;
    }

    public function saveGiftInfo($cart_id){
        if(@$this->cardFields[$cart_id]['giver_name'] == "" || 
           @$this->cardFields[$cart_id]['giver_address'] == ""){
            return $this->giftError = __('Please enter required fields (Name and Address)');
        }

        // if(!empty($this->cardFields[$cart_id]['giver_mobile'])) {
        //     $mobile = $this->cardFields[$cart_id]['giver_mobile'];
        //     if(strlen($mobile) != 9 || !is_numeric($mobile)) {
        //         return $this->giftError = __('Mobile number must be 9 digits');
        //     }
        // }

        $this->dispatchBrowserEvent('closemodal', $cart_id);
        $this->emit('closemodal', "$cart_id");
        
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

    public function plus($id){
        $this->cart->plusItem($id);
        $this->emit('cartUpdated');
    }

    public function minus ($id){
        $this->cart->minusItem($id);
        $this->emit('cartUpdated');
    }  

    public function removeItem($id){
        $this->cart->removeItem($id);
        $this->emit('cartUpdated');
    }

    public function emptyCart(){
        $this->cart->empty();
        $this->emit('cartUpdated');
    }

    public function render()
    {
        $this->items =  $this->cart->getItems();
        return view('livewire.site.carts.show');
    }
}