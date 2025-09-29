<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagProductTranslation extends Model
{
    use HasFactory;
    protected $table = 'tag_product_translations';
    protected $fillable = [
        'tag_id',
        'title',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_key',
        'locale',

     ];
}
