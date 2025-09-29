<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, Translatable, SoftDeletes;

    protected $fillable = [
        'image',
        'sort',
        'status',
        'feature',
        'news_ticker',
        'created_by',
        'updated_by',
    ];

    public $translatedAttributes = [
        'news_id',
        'locale',
        'title',
        'slug',
        'description',
        'content',
        'meta_title',
        'meta_description',
        'meta_key',
    ];
    protected $translationForeignKey = 'news_id';


    public function trans()  
    {
        return $this->hasMany(NewsTranslation::class, 'news_id', 'id');
    }

    public function scopeActive($query){
        return $query->where('status', 1);
    }
    public function scopeFeature($query){
        return $query->where('feature', 1);
    }
}
