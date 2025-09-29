<?php

namespace App\View\Components\Site\Home;

use App\Charity\Settings\SettingSingleton;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Bouquets extends Component
{
    public $settings;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->settings = SettingSingleton::getInstance();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.site.home.bouquets');
    }
}
