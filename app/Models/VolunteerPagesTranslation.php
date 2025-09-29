<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerPagesTranslation extends Model
{
    use HasFactory;

    protected $table = 'volunteer_pages_translations';
    protected $fillable = [
        'VolunteerPage_id',
        'title',
        'slug',
        'content',
        'meta_description',
        'meta_title',
        'meta_key',
        'locale',
     ];
}
