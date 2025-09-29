<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsTranslation extends Model
{
    protected $table = 'projects_translations';

    protected $fillable = [
        'project_id',
        'locale',
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'meta_key',
    ];

}
