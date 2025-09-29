<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory, Translatable, SoftDeletes;
    
    public $translatedAttributes = ['title', 'slug', 'description', 'store_id', 'locale', 'meta_title', 'meta_description', 'meta_key'];

    protected $fillable = [
        'account_id',
        'full_name',
        'mobile',
        'whatsapp',
        'employee_name',
        'employee_number',
        'employee_image',
        'department',
        'ax_store_number',
        'jop',
        'location',
        'background_image',
        'background_color',
        'api_url',
        'domain_url',
        'status',
        'created_by',
        'updated_by',
      
    ];
    protected $translationForeignKey = 'store_id';

    // relations ---------------------------------------------------------------------------------
    public function trans()
    {
        return $this->hasMany(StoreTranslation::class, 'store_id', 'id');
    }
}
