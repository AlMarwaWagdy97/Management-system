<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppSection extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    protected $fillable = [
        'sort',
        'image',
        'feature',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $translationForeignKey = 'section_id';
    public $translatedAttributes = [
        'section_id',
        'locale',
        'title',
        'slug',
        'description',
    ];


    public function trans(){
        return $this->hasOne(AppSectionTranslation::class, 'section_id', 'id')->where('locale' , app()->getLocale());
    }
  


    // Scopes ----------------------------
    public function scopeActive($query){
        return $query->where('status', 1);
    }
    public function scopeFeature($query){
        return $query->where('feature', 1);
    }

}
