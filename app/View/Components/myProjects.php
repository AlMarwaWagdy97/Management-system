<?php

namespace App\View\Components;

use Illuminate\View\Component;

class myProjects extends Component
{
    public $categories;
    public $tags;
    public $payments;


    public function __construct($categories, $tags, $payments)
    {
        $this->categories = $categories;
        $this->tags = $tags;
        $this->payments = $payments;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.my-projects');
    }
}
