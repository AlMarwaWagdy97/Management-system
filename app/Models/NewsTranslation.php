<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsTranslation extends Model
{
    use HasFactory;
    protected $table = 'news_translations';

    protected $fillable = [
        'news_id',
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
