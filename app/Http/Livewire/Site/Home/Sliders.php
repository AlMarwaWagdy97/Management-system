<?php

namespace App\Http\Livewire\Site\Home;

use Livewire\Component;
use App\Models\Slider; 

class Sliders extends Component
{
    public $slides;

    public function mount()
    {
        $this->slides = Slider::query()->with(['trans' => function ($query) {
            $query->where('locale', app()->getLocale());
        }])->orderBy('sort', 'asc')->active()->get();
    }
    
    public function render()
    {
        return view('livewire.site.home.sliders');
    }
}
