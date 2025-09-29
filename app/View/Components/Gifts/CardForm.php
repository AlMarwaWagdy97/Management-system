<?php

namespace App\View\Components\Gifts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Charity\Settings\SettingSingleton;

class CardForm extends Component
{
    public $cards;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $gift_setting = SettingSingleton::getInstance();
        $this->cards  =  $gift_setting->getGift('gift_category');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.gifts.card-form');
    }
}
