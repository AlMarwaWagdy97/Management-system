<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesTranslation extends Model
{
    use HasFactory;
    protected $table = 'services_translations';

    protected $fillable = [
        'service_id',
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
