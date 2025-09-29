<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesTranslation extends Model
{
    use HasFactory;

    protected $table = 'categories_translations';
    
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'meta_description',
        'meta_title',
        'meta_key',
        'locale',
     ];


}
