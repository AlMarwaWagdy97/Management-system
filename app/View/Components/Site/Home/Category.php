<?php

namespace App\View\Components\Site\Home;

use App\Charity\Settings\SettingSingleton;
use App\Models\CategoryProjects;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Category extends Component
{

    public $categories, $mainCategory, $showSection;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->categories = CategoryProjects::active()->feature()//->normal()->descesd()
        ->whereNull('parent_id')->with(['trans' => function($query){
            $query->where('locale', app()->getLocale());
        }])->get();

        $this->mainCategory = $this->categories->where('main_home', 1)->take(4);

        $settings = SettingSingleton::getInstance();
        $this->showSection = $settings->getItem('show_category');


    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.site.home.category');
    }
}
