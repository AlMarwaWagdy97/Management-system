<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorTranslation extends Model
{
    use HasFactory;
    protected $table = 'vendor_translations';
    protected $fillable = [
        'vendor_id',
        'title',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_key',
        'locale',
    ];
}
