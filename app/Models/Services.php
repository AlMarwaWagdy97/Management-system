<?php

namespace App\Models;

use App\Models\ServicesTranslation;
use App\Models\ServicesTranslations;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Services extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    protected $fillable = [
        'image',
        'sort',
        'status',
        'feature',
        // 'news_ticker',
        'created_by',
        'updated_by',
    ];

    public $translatedAttributes = [
        'service_id',
        'locale',
        'title',
        'slug',
        'description',
        'content',
        'meta_title',
        'meta_description',
        'meta_key',
    ];
    protected $translationForeignKey = 'service_id';


    public function trans()  
    {
        return $this->hasMany(ServicesTranslation::class, 'service_id', 'id');
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
