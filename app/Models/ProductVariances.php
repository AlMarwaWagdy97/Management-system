<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\ProductAttributesVales;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariances extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'variance_id',
        'default',
    ];
    public function attributeValue()
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes_vales', 'variance_id', 'attribute_value_id')->with('trans', 'attributeSet');
    }

    public function productVariance()
    {
        return $this->belongsTo(Product::class, 'variance_id')->with('trans');
    }

    public function productAttributeVariance()
    {
        return $this->hasMany(ProductAttributesVales::class, 'variance_id');
    }
}
