<?php

namespace App\Http\Livewire\Site\FastDonation\Payments;

use App\Enums\SourcesEnum;
use App\Http\Controllers\Site\CheckoutController;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class Visa extends Component
{

    public $payment_method_id = 2;
    public $card_number ="", $card_name ="", $expired_year ="", $expired_month ="", $cvv ="";
    public $selected_card = "", $selected_cvv = "", $savecard = "";
    public $myCards = [], $showNewCard = true;
    public $donationData;

    protected $listeners = ['getFastDonationData'];

    public function getFastDonationData($donationData)
    {
        $this->donationData = $donationData;
    }

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

    public function updated($field)
    {
        $this->validateOnly($field);
    }


    public function getSanitized()
    {
        $data = $this->validate();
        $data['payment_method_id'] = $this->payment_method_id;
        return $data;
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

    public function checkout(){
        $data = $this->getSanitized();

        $data['mobile']       = @$this->donationData['mobile'];
        $data['name']         = @$this->donationData['name'];

        $data['total']        = $this->donationData['donationAmt'];
        $data['quantity']     = 1;
        $data['source']       = SourcesEnum::WEB;
        $data['refer_id']  = Cookie::get('referrer');

        $data['item_id']      =  $this->donationData['project']['id'];
        $data['item_name']    =  $this->donationData['project_name'];
        $data['item_type']    =  $this->donationData['donationtype'];

        if($data['mobile'] == ""){
            $this->emit('updateMessage', trans("Please fill in the mobile number to proceed."));
            return;
        }
        if($data['name'] == ""){
            $this->emit('updateMessage', trans("Please fill in the name to proceed."));
            return;
        }
        if($data['total'] == ""){
            $this->emit('updateMessage', trans("Please choose the donation amount"));
            return;
        }
        return redirect(route('site.payments.fastdonation.intital', $data));
        // Make Order ---
       
    }
   

    public function mount(){
        if(@auth('account')->user()?->types->where('type', 'donor')->first() != null){
           $donor = @auth('account')->user()->donor;
           $this->myCards = $donor->cards;
           $this->showNewCard = false;
        }
    }
    
    public function render()
    {
        return view('livewire.site.fast-donation.payments.visa');
    }
}
