<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreTranslation extends Model
{
    use HasFactory;
    protected $table = 'store_translations';

    protected $fillable = [
        'store_id',
        'locale',
        'title',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_key',

    ];
}
