<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeSetTranslation extends Model
{
    use HasFactory;
    protected $table = 'attribute_set_translations';

    protected $fillable = [
        'attributeSet_id',
        'locale',
        'title',
        'slug',
    ];
}
