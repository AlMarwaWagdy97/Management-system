<?php

namespace App\View\Components;

use Illuminate\View\Component;

class myProjectEdit extends Component
{
    public $categories;
    public $tags;
    public $payments;
    public $items;
    public $donation;
    public $decease;

    public function __construct($categories, $tags, $payments, $items, $decease = null)
    {
        $this->categories = $categories;
        $this->tags = $tags;
        $this->payments = $payments;
        $this->items = $items;
        $this->donation =  json_decode($items->donation_type, true);
        // $donation =  json_decode($this->donation, true);
        // dd($items->donation_type, $this->donation);
        $this->decease = $decease;
    }
    /*/
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.my-project-edit');
    }
}
