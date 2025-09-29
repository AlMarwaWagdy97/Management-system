<?php

namespace App\Models;

use App\Models\Product;
use App\Models\TagProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductTagPivot extends Model
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

    public function tag(){
        return $this->belongsTo(TagProduct::class, 'tag_id');
    }
}
