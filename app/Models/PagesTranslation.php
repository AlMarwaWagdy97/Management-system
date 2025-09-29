<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagesTranslation extends Model
{
    use HasFactory;

    protected $table = 'pages_translations';
    protected $fillable = [
        'page_id',
        'title',
        'slug',
        'content',
        'meta_description',
        'meta_title',
        'meta_key',
        'locale',
     ];

}
