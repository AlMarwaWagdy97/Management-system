<?php

namespace App\Http\Livewire\Site\Home;

use Livewire\Component;
use App\Models\CategoryProjects;
use App\Charity\Settings\SettingSingleton;

class Tabs extends Component
{
    public $categories, $firstCategory;

    public  $colors = [], $colorsCategory = ['bg-main', 'bg-primary', 'bg-secound', 'bg-dark'];

    public $showModal = false, $productStatus = null, $productFastColor;

    public $giftData, $showCategory;



    function mount() {
        // define color categories
        $settings = SettingSingleton::getInstance();
        $this->colors = $settings->getColor('categoryColorlist');
        // define categories
        $this->categories =  CategoryProjects::active()->feature()//->normal()->descesd()
        ->whereNull('parent_id')->with(['trans' => function($query){
            $query->where('locale', app()->getLocale());
        }])->get();

        $this->firstCategory = @$this->categories->first()->id;

        $this->productStatus = $settings?->getProductsData('status');
        $this->productFastColor = $settings?->getProductsData('background_color');


        $this->giftData = [
            'title' => json_decode(@$settings->getProductsData(app()->getLocale()))?->title,
            'image' => @$settings->getProductsData('image'),
        ];
        $this->showCategory =  $settings->getItem('show_category') ;
    }


    public function render()
    {
        return view('livewire.site.home.tabs');
    }
}
