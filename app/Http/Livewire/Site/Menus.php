<?php

namespace App\Http\Livewire\Site;

use App\Models\Menue;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class Menus extends Component
{

    public $items;
    
    public function mount(){ 
        $this->items = Cache::get('menus');
        if( $this->items == null){
            $this->items = Cache::rememberForever('menus', function () {
                return Menue::with('trans')->main()->active()->get();
            });
        }
    }

    public function render()
    {
        return view('livewire.site.menus');
    }
}
