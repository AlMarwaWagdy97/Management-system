<?php

namespace App\View\Components\Site;

use Closure;
use App\Models\Settings;
use App\Models\GiftCategories;
use App\Models\GiftOccasioins;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class GiftsComponent extends Component
{
    public $cards, $occasioins, $category;
    public $gift_type;

    /**
     * Create a new component instance.
     */
    
    public function __construct()
    {
        // $this->category = GiftCategories::with('trans')->where('status', 1)->get();
        // $this->occasioins = GiftOccasioins::with('trans')->where('status', 1)->get();
        $gift_setting = Settings::with('values')->where('key', 'gift')->first();
        $cards =  $gift_setting->values->where('key', 'gift_category')->first()->value;
        $this->cards =  json_decode($cards);
    }


    public function onSelectGiftType($val){
        dd($val);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.site.gifts-component');
    }
}
