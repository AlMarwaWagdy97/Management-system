<?php

namespace App\View\Components;

use Illuminate\View\Component;

class myProjectShow extends Component
{
    public $categories;
    public $tags;
    public $payments;
    public $items;

    public function __construct($categories, $tags, $payments, $items)
    {
        $this->categories = $categories;
        $this->tags = $tags;
        $this->payments = $payments;
        $this->items = $items;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.my-project-show');
    }
}
