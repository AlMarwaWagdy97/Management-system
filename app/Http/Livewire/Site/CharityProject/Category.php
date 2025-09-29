<?php

namespace App\Http\Livewire\Site\CharityProject;

use App\Models\CharityProject;
use Livewire\Component;

class Category extends Component
{
    public $category, $projects;

    public $projectCarousels = [];
    public $projectsCount;

    /**
     * select the categories  of selected section
     */
    public function updateProjects($carouselIndex = 0)
    {
        // get Count  of Projects
        $query = CharityProject::status(1)->Web()->orderBy('sort','ASC')
        ->with(['trans' => function ($query) {
            $query->where('locale', app()->getLocale());
        }])->whereHas('categories', function($q){
            $q->where('category_id', $this->category->id);
        });
        
        $this->projectsCount = $query->count();
        // get projectCarousels
        $this->projectCarousels[$carouselIndex] = $query->offset($carouselIndex * 8)->limit(8)->get()->toArray();
    }

    /**
     * load another num projets
    */
    public function loadProjects(){
        $this->updateProjects(count($this->projectCarousels));
    }

    public function mount(){
        $this->updateProjects();
    }

    public function render()
    {
        return view('livewire.site.charity-project.category');
    }
}
