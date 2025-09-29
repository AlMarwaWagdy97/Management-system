<?php

namespace App\Http\Livewire\Admin\Ads;

use Livewire\Component;

class Form extends Component
{
    public $ads ;
    public $index;


    // protected $listeners = ['getAdsData'];

    
    public function render() {
        $this->emit('getAdsData', $this->ads);
        return view('livewire.admin.ads.form');
    }

    // public function getAdsData(){
    //     return $this->ads;
    // }
    public function getads(){
        dd($this->ads);
        return $this->ads;
    }

}
