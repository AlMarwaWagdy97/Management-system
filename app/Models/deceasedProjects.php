<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class deceasedProjects extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'deceased_id',
        'is_approved',
    ];
}


