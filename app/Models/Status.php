<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory, Translatable, SoftDeletes;
    public $translatedAttributes = ['title', 'slug', 'description', 'status_id', 'locale'];


    protected $fillable = [
        'status',
        'color',
        'created_by',
        'updated_by',
    ];
    protected $translationForeignKey = 'status_id';

    public function trans()
    {
        return $this->hasMany(StatusTranslation::class, 'status_id');
    }

    public function trans_ar()
    {
        return $this->hasOne(StatusTranslation::class, 'status_id', 'id')->where('locale', 'ar');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'status_id');
    }

    // Scopes ----------------------------
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
