<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiftCategories extends Model
{
    use HasFactory, Translatable, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'level',
        'sort',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $translationForeignKey = 'category_id';

    public $translatedAttributes = [
        'category_id',
        'locale',
        'title',
    ];

    public function trans()
    {
        return $this->hasMany(GiftCategoriesTranslation::class, 'category_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(GiftCategories::class, 'parent_id', 'id');
    }
    public function children()
    {
        return $this->hasMany(GiftCategories::class, 'parent_id', 'id');
    }



    public function scopeActive($query){
        return $query->where('status', 1);
    }
}

