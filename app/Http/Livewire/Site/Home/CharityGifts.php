<?php

namespace App\Http\Livewire\Site\Home;


use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Component;

class CharityGifts extends Component
{
    public $categories = [], $selectedCategory = null, $SelectedCategoriesIDs = [];

    public $giftProducts = [];

    public $productsCarousels = [], $productsCount;

    public $pageCount = 3;


    /**
     * load another num products
     */
    public function loadProducts()
    {
        $this->getProducts(count($this->productsCarousels));
    }

    /**
     * get products
     * @param int $carouselIndex
     *
     * @return [type]
     */
    public function getProducts($carouselIndex = 0)
    {
        $query = Product::active()->orderBy('sort', 'ASC')->with(['Category', 'trans' => function ($query) {
            $query->where('locale', app()->getLocale());
        }]);

        if($this->selectedCategory) $query->where('category_id', $this->selectedCategory);

        $this->productsCount = $query->count();
        $this->productsCarousels[$carouselIndex] = $query->offset($carouselIndex * $this->pageCount)->limit($this->pageCount)->get()->toArray();
    }


    /**
     * update the selected the the products
     * @param mixed $id
     *
     * @return [type]
     */
    public function selectCategory($selectedCategory){
        $this->selectedCategory = $selectedCategory;
        $this->productsCarousels = [];
        $this->getProducts();
    }


    public function mount()
    {
        $this->getProducts($carouselIndex = 0);

        $this->categories = ProductCategory::with('trans')->active()->get();
    }

    public function render()
    {
        return view('livewire.site.home.charity-gifts');
    }
}
