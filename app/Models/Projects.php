<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    protected $fillable = [
        'portfolio_id',
        'image',
        'sort',
        'status',
        'created_by',
        'updated_by',
    ];
    protected $translationForeignKey = 'project_id';
    public $translatedAttributes = [
        'project_id',
        'locale',
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'meta_key',
    ];


    // relations ---------------------------------------------------------------------------------
    public function trans(){
        return $this->hasMany(ProjectsTranslation::class, 'project_id', 'id');
    }

    public function portfolio(){
        return $this->belongsTo(Portfolios::class, 'portfolio_id')->with('trans');
    }


    public function images() {
        return $this->morphMany(Images::class, 'parentable')->orderBy('sort', 'ASC');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'cartable_id')->where('cartable_type', self::class);
    }

    // Scopes ---------------------------------------------------------------------------------
    public function scopeActive($query){
        return $query->where('status', 1);
    }


}

