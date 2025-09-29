<?php

namespace App\Http\Livewire\Admin\Product;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductVariances;
class VarianceProductForm extends Component
{
    public 
        $product,
        $products,
        $attribute_set,
        $product_id,
        $unique_attributeSet,
        $attributes = [],
        $sku,
        $price,
        $sale_price,
        $start_at, $end_at,
        $image,
        $masgess = false,
        $quantity,
        $modelId,
        $attribut_set,
        $attributeValue;

    protected $listeners = ['getModelId',  'forcedCloseModal', 'updateAttForm' => '$refresh'];
    
    public function mount()
    {
        $this->products = Product::findOrFail($this->product_id);
    }

    public function updateAttrSet(){
        
    }

    // getModelId
    public function getModelId($modelId = null){
        $this->modelId = $modelId;
        // get all variance
        $model =  Product::with('variances')->findOrFail($this->modelId);
        $attribut_set = $this->products->attributeSet()->get();
        $this->product_id = $model->id;
        $this->sku = $model->sku;
        $this->price = $model->price;
        $this->sale_price = $model->sale_price;
        $this->quantity = $model->quantity;
        $this->start_at = $model->start_at;
        $this->end_at = $model->end_at;
        // get all attribut set
        $this->attributeValue = $model->variances->attributeValue;
        foreach ($attribut_set  as $key => $item) {
            $varianceAttributeValues = $this->attributeValue->pluck('id')->toArray();
            $value = $item->attribute()->whereIn('id', $varianceAttributeValues )->first();
            $this->attributes[$item->id] = @$value->id;
        }
    }

    // create Method 
    public function save(){
        $validateData = [
            'attributes'        => 'required|array',
            'attributes.*'      => 'required',
            'sku'               => 'required',
            'price'             => 'required',
            'quantity'          => 'required',
            'sale_price'       => 'nullable',
            'start_at'          => 'nullable',
            'end_at'            => 'nullable',

        ];
        $data = $this->validate($validateData);
        // insert Data in database
            if($this->modelId){
                $model =  Product::with('variances')->findOrFail($this->modelId);
                $model->sku = $data['sku'];
                $model->price = $data['price'];
                $model->sale_price = $data['sale_price'];
                $model->quantity = $data['quantity'];
                $model->start_at = $data['start_at'];
                $model->end_at = $data['end_at'];
                $model->save();
                $model->variances->attributeValue()->sync($data['attributes']);
            }else{
                $products = $this->products;
                $variance = new Product();
                $variance->sku = $data['sku'];
                $variance->price = $data['price'];
                $variance->sale_price = $data['sale_price'];
                $variance->start_at = $data['start_at'];
                $variance->end_at = $data['end_at'];
                $variance->is_variance = 1;
                $variance->sort = $products->sort;
                $variance->quantity = $products->quantity;
                $variance->status = $products->status;
                $variance->is_cheacked = $products->is_cheacked;
                $variance->feature = $products->feature;
                $variance->vendor_id = $products->vendor_id;
                $variance->category_id = $products->category_id;
                // $variance->image = $data['image'];
                $variance->save();
        
                $products_variances = ProductVariances::create([
                    'product_id' => $products->id,
                    'variance_id' => $variance->id,
                    'default' => 0
                ]);
        
                foreach ($data['attributes'] as $key => $value) {
                    // $products->attributeSet()->attach($key);
                    $products_variances->attributeValue()->attach($value);
                }
        
            }

        $this->clearForm();
        $this->emit('updateTable');
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('success', trans('message.admin.created_sucessfully'));
    }

    public function clearForm()
    {
        $this->product_id = null;
        $this->attributes = null;
        $this->sku = null;
        $this->price = null;
        $this->sale_price = null;
        $this->start_at = null;
        $this->end_at = null;
        $this->image = '';
        $this->masgess = false;
        
    }
    public function forcedCloseModal()
    {
        // This is to reset our public variables
        $this->clearForm();

        // These will reset our error bags
        $this->resetErrorBag();
        $this->resetValidation();
    }


    public function render()
    {
        $this->unique_attributeSet = $this->products->attributeSet()->with('trans')->get();
        return view('livewire.admin.product.variance-product-form');
    }

}
