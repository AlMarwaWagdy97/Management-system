<?php

namespace App\Models;

use App\Models\PagesTranslation;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Pages extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    protected $fillable = ['image',  'status', 'created_by', 'updated_by'];
    // transatable table
    public $translatedAttributes = ['page_id', 'locale', 'title', 'slug', 'content','meta_title' ,'meta_description','meta_key'];
    // foreign key  
    protected $translationForeignKey = 'page_id';

    public function trans(){
        return $this->hasMany(PagesTranslation::class,'page_id');
    }


    // Scopes ----------------------------
    public function scopeActive($query){
        return $query->where('status', 1);
    }
    public function scopeLang($query){
        return $query->trans->where('locale',  app()->getLocale())->first();
    }


}
