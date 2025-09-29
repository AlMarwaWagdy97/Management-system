<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenueTranslation extends Model
{
    use HasFactory;

    protected $table = 'menue_translations';
    protected $fillable = [
        'menue_id',
        'title',
        'slug',
        'locale',
     ];
}
