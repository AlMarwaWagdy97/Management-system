<?php

namespace App\View\Components\Gifts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Request;
use App\Charity\Settings\SettingSingleton;

class CardImg extends Component
{
    public $selectedCard, $cards;
    public $giftType;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->giftType = Request::input('giftType');
        $gift_setting = SettingSingleton::getInstance();
        $this->cards  =  $gift_setting->getGift('gift_category');

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if($this->giftType != ""){
            $cardImages =  json_decode($this->cards, true)[$this->giftType]['images'];
        }
        else{
            $cardImages = "";
        }
        $randName = rand(1,999);
        return view('components.gifts.card-img', compact('cardImages', 'randName'));
    }
}
