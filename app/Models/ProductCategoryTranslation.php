<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryTranslation extends Model
{
    use HasFactory;
    protected $table = 'product_category_translations';

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'content',
        'meta_description',
        'meta_title',
        'meta_key',
        'locale',
    ];
}
