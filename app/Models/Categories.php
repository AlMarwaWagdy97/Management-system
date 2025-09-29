<?php

namespace App\Models;

use App\Models\Articles;
use App\Models\CategoriesTranslation;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categories extends Model
{
    use HasFactory, Translatable, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'level',
        'sort',
        'back_home',
        'feature',
        'status',
        'kafara',
        'image',
        'background_image',
        'background_color',
        'section_bg',
        'created_by',
        'updated_by',
    ];

    protected $translationForeignKey = 'category_id';

    public $translatedAttributes = [
        'category_id',
        'locale',
        'title',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_key',
    ];

    public function trans()
    {
        return $this->hasMany(CategoriesTranslation::class, 'category_id', 'id');
    }
    public function transNow()
    {
        return $this->hasOne(CategoriesTranslation::class, 'category_id', 'id')->where('locale' , app()->getLocale());
    }

    public function parent()
    {
        return $this->belongsTo(Categories::class, 'parent_id', 'id');
    }
    public function children()
    {
        return $this->hasMany(Categories::class, 'parent_id', 'id');
    }
    public function articles()
    {
        return $this->hasMany(Articles::class, 'category_id', 'id')->active();
    }
    public function portfoliosFeature()
    {
        return $this->hasMany(Portfolios::class, 'category_id', 'id')->active()->feature();
    }


    // Scopes ----------------------------
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function scopeFeature($query)
    {
        return $query->where('feature', 1);
    }
}
