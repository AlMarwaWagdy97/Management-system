<?php

namespace App\View\Components\Site\Home;

use App\Charity\Settings\SettingSingleton;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Slider; 

class Sliders extends Component
{
    public $slides, $settings;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->slides = Slider::query()->with(['trans' => function ($query) {
            $query->where('locale', app()->getLocale());
        }])->orderBy('sort', 'asc')->active()->get();

        $this->settings = SettingSingleton::getInstance();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.site.home.sliders');
    }
}
