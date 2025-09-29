<?php

namespace App\Http\Livewire\Site\CharityCategory;

use App\Models\CategoryProjects;
use Livewire\Component;

class Index extends Component
{


    public $categories;

    public $categoriesCarousels = [];
    public $categoriesCount;

    /**
     * select the categories  of selected section
     */
    public function updateCategories($carouselIndex = 0)
    {
        // get Count  of Projects
        $query = CategoryProjects::active()->orderBy('sort','ASC')
        ->with(['trans' => function ($query) {
            $query->where('locale', app()->getLocale());
        }]);

        $this->categoriesCount = $query->count();
        // get projectCarousels
        $this->categoriesCarousels[$carouselIndex] = $query->offset($carouselIndex * 8)->limit(8)->get()->toArray();
    }

    /**
     * load another num projets
    */
    public function loadCategories(){
        $this->updateCategories(count($this->categoriesCarousels));
    }

    public function mount(){
        $this->updateCategories();
    }


    public function render()
    {
        return view('livewire.site.charity-category.index');
    }
}
