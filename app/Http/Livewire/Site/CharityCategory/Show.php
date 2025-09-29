<?php

namespace App\Http\Livewire\Site\CharityCategory;

use App\Models\CharityProject;
use Livewire\Component;

class Show extends Component
{

    public $category, $projects;

    public $selectedCategoryID = 0;

    public $projectCarousels = [];
    public $projectsCount;



    public function mount($category){
        $this->category = $category;
        //  selected category by default first
        $this->selectedCategoryID = $this->category?->id;
        // get the project of selected category 
        $this->updateProjects();
    }


    /**
     * load another num projets
    */
    public function loadProjects(){
        $this->updateProjects(count($this->projectCarousels));
    }
  
    
    /**
     * select the categories  of selected section
     */
    public function updateProjects($carouselIndex = 0)
    {
        // get Count  of Projects
        $query = CharityProject::with('trans')->active()->featuer()->Web()->orderBy('sort', 'ASC')
            ->with(['categories', 'trans' => function ($query) {
                $query->where('locale', app()->getLocale());
            }])
            ->whereHas('categories', function ($q) {
                $q->where('category_id', $this->selectedCategoryID);
            });

        $this->projectsCount = $query->count();
        // get projectCarousels
        $this->projectCarousels[$carouselIndex] = $query->offset($carouselIndex * 3)->limit(3)->get()->toArray();
    }

    

    public function render()
    {
        return view('livewire.site.charity-category.show');
    }
}
