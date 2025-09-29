<?php

namespace App\View\Components\Site\vendors;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SideMenu extends Component
{
    public $vendor;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        if(auth('account')->user()?->types->where('type', 'vendor')->first() != null){
            $this->vendor = auth('account')->user()->vendor;
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
        return view('components.site.vendors.side-menu');
    }
}
