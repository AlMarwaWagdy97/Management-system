<?php

namespace App\Http\Livewire\Admin\Product;

use App\Models\Product;
use App\Models\ProductVariances;

use Livewire\Component;

class VarianceProductTable extends Component
{
    public $product, $unique_attributeSet;
    public $action;
    public $selectedItem;
    public $attribut_set;
    public $default;
    protected $listeners = ['updateTable' => '$refresh'];

    public function selectItem($itemId, $action)
    {
        $this->selectedItem = $itemId;
        if ($action == 'delete') {
            $this->dispatchBrowserEvent('openDeleteModal');
        } else {
            $this->dispatchBrowserEvent('openModal');
            $this->emit('getModelId', $this->selectedItem);
        }
    }
    public function delete()
    {
        $variance = ProductVariances::with('attributeValue', 'productVariance')->findOrFail($this->selectedItem);
        $variance->productAttributeVariance()->delete();
        $variance->productVariance->delete();
        $variance->delete();
        $this->dispatchBrowserEvent('closeDeleteModal');
    }

    public function remove_image($image, Product $variance){
        
        $variance->image = str_replace($image, "",  $variance->image);
        $variance->image = str_replace(',""', "",  $variance->image);
        $variance->image = str_replace('""', "",  $variance->image);
        $variance->image = str_replace('[]', "",  $variance->image);
        $variance->save();
        $this->mount();
    
    }

    public function addimage(){
        dd("change");
    }

    public function changeDefault($id){
        $product = $this->product;
        $variances = $product->product;

        $variances->map(function($item){
            $item->default = 0;
            $item->save();
        });

        $selected = $variances->where('id', $id)->first();
        $selected->default = 1;
        $selected->save();
    }
    public function mount()
    {
    //  if no default set first is default
        $product =  $this->product;
        $variances = $product->product;
        if($variances->where('default', 1)->count() == 0){
            $firstVariance = $variances->first();
            $firstVariance->default = 1;
            $firstVariance->save();
            $this->default = $variances->first()->id;
        }
        else{
             $this->default = $variances->where('default', 1)->first()->id;
        }
    }

    public function render()
    {
        $this->unique_attributeSet = $this->product->attributeSet()->with('trans')->get();
        return view('livewire.admin.product.variance-product-table', ['variances' => Product::with('product')->find($this->product->id)->product]);
    }
}
