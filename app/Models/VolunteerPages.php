<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\VolunteerPagesTranslation;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VolunteerPages extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    protected $fillable = ['image',  'status', 'created_by', 'updated_by'];
    // transatable table
    public $translatedAttributes = ['VolunteerPage_id', 'locale', 'title', 'slug', 'content','meta_title' ,'meta_description','meta_key'];
    // foreign key  
    protected $translationForeignKey = 'VolunteerPage_id';

    public function trans(){
        return $this->hasMany(VolunteerPagesTranslation::class,'VolunteerPage_id');
    }


    // Scopes ----------------------------
    public function scopeActive($query){
        return $query->where('status', 1);
    }

}
