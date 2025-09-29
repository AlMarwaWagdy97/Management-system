<?php

namespace App\Http\Livewire\Site\Home;

use Livewire\Component;
use App\Models\CategoryProjects;
use App\Models\CharityProject;

class SubCategories extends Component
{
    protected $listeners = ['changeSelection'];

    public $selectedCategory = "", $subcategories, $firstCategory;

    public $selectedSubcategory = 0, $SelectedsubcategoriesIDs; 


    public $projectCarousels = [];
    public $projectsCount;


    /**
     * update the select section when scroll sections
     *
     * @param  int  $id of section
     */
    public function changeSelection($val)
    {
        $this->selectedCategory  = $this->firstCategory =  $val;
        $this->updateSubCategory();
    }


    /**
     * select cataegory
     *     
     * @param  int  $carouselIndex get another 
    */
    public function selectSubcategory($selectedCategory)
    {
        if($selectedCategory == 0){
            $this->selectedSubcategory = 0;
            $this->updateSubCategory(); 
        }
        else{
            $this->SelectedsubcategoriesIDs = [ $this->selectedSubcategory = $selectedCategory]; 
        }
        $this->projectCarousels = [];
        $this->updateProjects();
    }


    /**
     * select the categories  of selected section
     */
    public function updateSubCategory()
    {
        // get the sub category 
        $this->subcategories =  CategoryProjects::active()->feature() //->normal()->descesd()
            ->where('parent_id', $this->selectedCategory)->with(['trans' => function ($query) {
                $query->where('locale', app()->getLocale());
            }])->get();
            if ($this->subcategories->count() != 0 ) { //fetch all projects under the main category
                $this->SelectedsubcategoriesIDs =  $this->subcategories->pluck('id')->toArray();
            } else {
                // $this->SelectedsubcategoriesIDs = [$this->selectedSubcategory];
                $this->SelectedsubcategoriesIDs = [$this->selectedSubcategory == 0 ? $this->firstCategory : $this->selectedSubcategory];
            }
        $this->projectCarousels = [];
        $this->updateProjects();
    }

     /**
     * select the categories  of selected section
     */
    public function updateProjects($carouselIndex = 0)
    {
        // get Count  of Projects
        $query = CharityProject::status(1)->featuer(1)->Web()->orderBy('sort','ASC')
        ->with(['categories', 'trans' => function ($query) {
            $query->where('locale', app()->getLocale());
        }])
        ->whereHas('categories', function($q){
            $q->whereIn('category_id', $this->SelectedsubcategoriesIDs);
        });
        
        $this->projectsCount = $query->count();
        // get projectCarousels
        $this->projectCarousels[$carouselIndex] = $query->offset($carouselIndex * 3)->limit(3)->get()->toArray();
  

    }

    /**
     * load another num projets
    */
    public function loadProjects(){
        $this->updateProjects(count($this->projectCarousels));
    }

    public function mount()
    {
        $this->selectedCategory = $this->firstCategory;
        $this->updateSubCategory();
        // $this->charityProjects = CharityProject::query();
    }

    public function render()
    {
        return view('livewire.site.home.sub-categories');
    }
}
