<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portfolios extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    protected $fillable = [
        'tag_id',
        'image',
        'sort',
        'status',
        'feature',
        'created_by',
        'updated_by',
    ];
    protected $translationForeignKey = 'portfolio_id';
    public $translatedAttributes = [
        'portfolio_id',
        'locale',
        'title',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_key',
    ];


    // relations ---------------------------------------------------------------------------------
    public function trans(){
        return $this->hasMany(PortfoliosTranslation::class, 'portfolio_id', 'id');
    }
    public function tag(){
        return $this->belongsTo(PortfolioTags::class, 'tag_id')->with('trans');
    }

    public function projects(){
        return $this->hasMany(Projects::class, 'portfolio_id', 'id')->with('trans');
    }

    public function projectsactive(){
        return $this->hasMany(Projects::class, 'portfolio_id', 'id')->with('trans', 'images')->active()->orderBy('sort', 'ASC');
    }


    // Scopes ---------------------------------------------------------------------------------
    public function scopeActive($query){
        return $query->where('status', 1);
    }
    public function scopeFeature($query){
        return $query->where('feature', 1);
    }
  

}

