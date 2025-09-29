<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    
    use HasFactory;

    protected $table = 'product_translations';

    protected $fillable = [
        'tag_id',
        'title',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_key',
        'locale',
        'content',
     ];
}
