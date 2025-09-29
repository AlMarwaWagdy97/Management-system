<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCategoryTranslation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use HasFactory, Translatable, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'level',
        'sort',
        'feature',
        'status',
        'image',
        'bcakground_image',
        'background_color',
        'created_by',
        'updated_by',
    ];

    protected $translationForeignKey = 'category_id';

    public $translatedAttributes = [
        'title',
        'slug',
        'content',
        'description',
        'meta_title',
        'meta_description',
        'meta_key',
    ];

    // relations ---------------------------------------------------
    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id', 'id');
    }
    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id');
    }
    public function trans()
    {
        return $this->hasMany(ProductCategoryTranslation::class, 'category_id', 'id');
    }

    public function scopeActive($query){
        return $query->where('status', 1);
    }
    public function scopeFeature($query){
        return $query->where('feature', 1);
    }
    
}
