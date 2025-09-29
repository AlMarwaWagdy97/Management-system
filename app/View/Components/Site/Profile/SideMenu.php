<?php

namespace App\View\Components\Site\Profile;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SideMenu extends Component
{
    public $donor; 

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        if(auth('account')->user()?->types->where('type', 'donor')->first() != null){
            $this->donor = auth('account')->user()->donor;
        }
        else{
            return redirect()->route('site.home');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.site.profile.side-menu');
    }
}
