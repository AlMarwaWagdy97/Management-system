<?php

namespace App\Models;

use App\Models\TagProductTranslation;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TagProduct extends Model
{
    use HasFactory, Translatable, SoftDeletes;
    public $translatedAttributes = [
        'title',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_key',
        'locale',
        'tag_id'
    ];
    protected $translationForeignKey = 'tag_id';
    protected $fillable=[
        'sort',
        'back_home',
        'image',
        'background_color',
        'background_image',
        'feature',
        'status',
        'created_by',
        'updated_by',
    ];

    // relations ------------------------------------------------------------------------------
    public function trans(){
        return $this->hasMany(TagProductTranslation::class ,'tag_id');
    }


    // Scopes ----------------------------
    public function scopeActive($query){
        return $query->where('status', 1);
    }
    public function scopeFeature($query){
        return $query->where('feature', 1);
    }
    public function scopeLang($query){
        return $query->trans->where('locale',  app()->getLocale())->first();
    }
}
