<?php

namespace App\Models;

use App\Models\Product;
use App\Models\AttributeSet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttributeSet extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'attribute_id',
    ];

    // relations
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function attributeSet(){
        return $this->belongsTo(AttributeSet::class, 'attribute_id');
    }
}
