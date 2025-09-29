<?php

namespace App\Http\Livewire\Site\Payments;

use App\Charity\Carts\DatabaseCart;
use App\Models\PaymentMethod;
use Livewire\Component;

class Visa extends Component
{
    public $payment_method_id = 2, $payment_method_key = 'Visa';
    public $card_number ="", $card_name ="", $expired_year ="", $expired_month ="", $cvv ="";
    public $selected_card = "", $selected_cvv = "", $savecard = "";
    public $myCards = [], $showNewCard = true;

    protected $listeners = ['updateAuth'];

    protected function rules(){
        if($this->selected_card){
            return [
                'selected_card' => 'required',
                'selected_cvv'  => 'required|min:3|max:3',
            ];
        }
        else{
            return [
                'card_number'   => 'required|min:16|max:16',
                'card_name'     => 'required|min:3',
                'expired_year'  => 'required|min:2|max:2',
                'expired_month' => 'required|min:2|max:2',
                'cvv'           => 'required|min:3|max:3',
                'savecard'      => 'nullable',
            ];
        }

    }

    // public function updated($field)
    // {
    //     $this->validateOnly($field);
    // }

    public function getSanitized()
    {
        $data = $this->validate();
        $data['payment_method_id'] = $this->payment_method_id;
        $data['payment_method_key'] = $this->payment_method_key;
        return $data;
    }

    public function checkout(){
        // checkinig if missing data
        $missId = $this->checkMissingData();
        if($missId){
            $this->emit('openModal', $missId);
            return false;
        }

        $data = $this->getSanitized();
        return redirect(route('site.payments.intital', $data));
    }

    public function checkMissingData(){
        $cart = new DatabaseCart();
        $cartItems = $cart->getItemsWithInfo();
        $products = $cartItems['cart']->where('item_type', 'App\Models\Product')->where('givten_details', null);
        if(!empty($products->first())){
            return $products->first()->id;
        }
    }

    public function UpdatedSelectedCard(){
        $this->showNewCard = 0;
        $this->selected_cvv = "";
    }
    public function addNewCardBlock(){
        $this->showNewCard = $this->showNewCard ?  0 : 1;
        $this->selected_card = "";
    }

    public function updateAuth()
    {
        if(@auth('account')->user()?->types->where('type', 'donor')->first() != null){
            $this->showNewCard = false;
            $this->render();
            $this->mount();
        }
    }

    public function mount(){
        if(@auth('account')->user()?->types->where('type', 'donor')->first() != null){
           $donor = @auth('account')->user()->donor;
           $this->myCards = $donor->cards;
           $this->showNewCard = false;
        }
        $this->payment_method_key = @PaymentMethod::find($this->payment_method_id)->payment_key;
    }

    public function render()
    {
        return view('livewire.site.payments.visa');
    }

}
