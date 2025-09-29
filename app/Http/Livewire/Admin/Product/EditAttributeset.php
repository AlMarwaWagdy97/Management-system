<?php

namespace App\Http\Livewire\Admin\Product;

use Livewire\Component;
use App\Models\AttributeSet;
use App\Models\Product;
use App\Models\ProductAttributesVales;

class EditAttributeset extends Component
{
    public $unique_attributeSet, $attributeSet, $attributes = [], $product_id, $products;

    public function mount()
    {
        $this->products = $this->products;
        $this->attributeSet = AttributeSet::query()->with('attribute', 'trans')->get();
        $this->attributes = [];
        // $this->attributes = $this->unique_attributeSet->pluck('id')->toArray();
        foreach ($this->unique_attributeSet->pluck('id')->toArray() as $key) {
            $this->attributes[$key] = true;
        }
    }
    public function rules()
    {
        return [
            'attributes' => 'required|array',
        ];
    }
    public function save()
    {

        $data = $this->validate();
        $this->products = Product::with('attributeSet', 'product')->findOrFail($this->product_id);
        $this->products->attributeSet()->sync([]);
        foreach ($data['attributes'] as $key => $val) {
            if ($val != false) {
                $this->products->attributeSet()->attach($key);
            }
        }

        $attrSetId = $this->products->attributeSet()->get()->pluck('id')->toArray();
        $varianceValue = $this->products->product->pluck('id')->toArray();
        $productAtrrValues = ProductAttributesVales::with('attributeValue')->whereIn('variance_id', $varianceValue)->get();
        foreach ($productAtrrValues as $attrValue) {
            if (!in_array($attrValue->attributeValue->attribute_set_id, $attrSetId)) {
                $attrValue->delete();
            }
        }
        $this->emit('updateTable');
        $this->emit('updateAttForm');
        $this->dispatchBrowserEvent('closeAttributesModal');
    }
    // ProductAttributeSet  $model->variances->attributeValue()->sync($data['attributes']);

    public function render()
    {
        return view('livewire.admin.product.edit-attributeset');
    }
}
