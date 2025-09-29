<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ads extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'model_id',
        'model',
        'image',
        'link',
    ];
    

    public function projectCategories(){
        return $this->belongsTo(CategoryProjects::class, 'id', 'model_id')->where('model', 'App\Models\CategoryProjects');
    }
}






