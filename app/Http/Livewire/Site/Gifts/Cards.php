<?php

namespace App\Http\Livewire\Site\Gifts;

use Livewire\Component;
use App\Charity\Settings\SettingSingleton;

class Cards extends Component
{

    public $giftStatus,  $cards, $occasioins, $category;
    public $giftType, $cardImages = "";
    public $giver_name, $giver_mobile,  $giver_email;
    public $selectCardTitle, $selectedCardImage, $sendCopy = 0;
    public $project, $donation, $colorsAmount;
   
    public $unitValueRadio, $unitValueInput, $donationAmt, $donation_status;

    public function updated($propertyName)
    {
        $this->giftInfo();
    }

    public function updatedGiftType()
    {
        if($this->giftType != ""){
            $selectedCard =  json_decode($this->cards, true)[$this->giftType];
            $this->selectCardTitle = $selectedCard['title_'.app()->getLocale()];
            $this->cardImages =  $selectedCard['images'];
        }
        else{
            $this->selectCardTitle = "";
            $this->cardImages = "";
        }
        $this->giftInfo();
    }

    public function giftInfo(){
        $giftInfo = [
            'giver_name' => $this->giver_name,
            'giver_mobile' => $this->giver_mobile,
            'giver_email' => $this->giver_email,
            'cardTitle' => $this->selectCardTitle,
            'cardImage' => $this->cardImages,
            'sendCopy' => $this->sendCopy,
        ];
        $this->emit('updateGiftInfo', json_encode($giftInfo));
    }

    public function updatedGiftStatus($val){
        return $this->emit('donationStatus', $val);
    }

    public function mount()
    {
        $gift_setting = SettingSingleton::getInstance();
        $this->cards  =  $gift_setting->getGift('gift_category');
    }

    public function sendCopy(){

    }


    public function render()
    {
        return view('livewire.site.gifts.cards');
    }
}