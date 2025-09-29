<?php

namespace App\Models;

use App\Models\VendorTranslation;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory, Translatable, SoftDeletes;
    
    public $translatedAttributes = ['title', 'slug', 'description', 'vendor_id', 'locale', 'meta_title', 'meta_description', 'meta_key'];

    protected $fillable = [
        'account_id',
        'responsible_person',
        'mobile',
        'logo',
        'sort',
        'status',
        'feature',
        'created_by',
        'updated_by',
      
    ];
    protected $translationForeignKey = 'vendor_id';

    // relations ---------------------------------------------------------------------------------
    public function trans()
    {
        return $this->hasMany(VendorTranslation::class, 'vendor_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo(Accounts::class, 'account_id', 'id');
    }
}
