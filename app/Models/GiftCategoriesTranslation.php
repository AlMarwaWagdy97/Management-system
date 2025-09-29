<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCategoriesTranslation extends Model
{
    use HasFactory;

    
    protected $table = 'gift_categories_translations';
    
    protected $fillable = [
        'category_id',
        'title',
        'locale',
    ];
}
