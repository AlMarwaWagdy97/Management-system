<?php

namespace App\View\Components\Site\Layouts;

use App\Charity\Settings\SettingSingleton;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    public $settings;
    public $main_color, $primary_color, $secound_color, $background_color ,$third_color ,$fourth_color,
    $title_footer, $bg_footer1, $bg_footer2;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->settings  = SettingSingleton::getInstance();
        $this->main_color  =  $this->settings->getTheme('main');
        $this->primary_color  =  $this->settings->getTheme('primary');
        $this->secound_color  =  $this->settings->getTheme('secound');
        $this->third_color  =  $this->settings->getTheme('third');
        $this->fourth_color  =  $this->settings->getTheme('fourth');
        $this->background_color  =  $this->settings->getTheme('background');
        $this->title_footer  =  $this->settings->getTheme('title_footer');
        $this->bg_footer1  =  $this->settings->getTheme('bg_footer1');
        $this->bg_footer2  =  $this->settings->getTheme('bg_footer2');
    }
   
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.site.layouts.header');
    }
}
