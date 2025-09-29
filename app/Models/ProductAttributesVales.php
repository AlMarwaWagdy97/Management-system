<?php

namespace App\Models;

use App\Models\Attribute;
use App\Models\ProductVariances;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttributesVales extends Model
{
    use HasFactory;

    protected $fillable = [
        'variance_id',
        'attribute_value_id',
    ];
        // relations
        public function productVariance(){
            return $this->belongsTo(ProductVariances::class, 'variance_id');
        }

        public function attributeSet(){
            return $this->belongsTo(Attribute::class, 'attribute_value_id');
        }
        public function attributeValue(){
            return $this->belongsTo(Attribute::class, 'attribute_value_id');
        }
}
