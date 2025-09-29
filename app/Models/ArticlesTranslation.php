<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticlesTranslation extends Model
{
    use HasFactory;
    protected $table = 'article_translations';

    protected $fillable = [
        'article_id',
        'locale',
        'title',
        'slug',
        'description',
        'content',
        'news_ticker',
        'meta_title',
        'meta_description',
        'meta_key',
    ];


    
}
