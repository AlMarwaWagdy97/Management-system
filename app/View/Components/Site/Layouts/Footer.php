<?php

namespace App\View\Components\Site\Layouts;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use App\Charity\Settings\SettingSingleton;
use App\Models\Menue;
use App\Models\PaymentMethod;

class Footer extends Component
{
    public $menus;
    public $settings;
    public $store;
    public $payment_methodImages;

    public function __construct()
    {
        $this->settings = SettingSingleton::getInstance();
        $this->store = @$_SESSION['referrer'];
        $this->payment_methodImages = PaymentMethod::active()->get()->pluck('image')->toArray();
        $this->menus = Menue::with('trans')->orderBy('sort', 'ASC')->footer()->active()->take(6)->get();
    }

    /**  
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // dd($this->store);
        return view('components.site.layouts.footer' , ['menuItems' => $this->menus]);
    }
}
