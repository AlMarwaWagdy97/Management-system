<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class badalProjects extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'bada_type',
        'min_price',
    ];
}


