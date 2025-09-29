<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSectionTranslation extends Model
{
    use HasFactory;
    protected $table = 'app_section_translations';

    protected $fillable = [
        'section_id',
        'locale',
        'title',
        'slug',
        'description',
    ];
}
