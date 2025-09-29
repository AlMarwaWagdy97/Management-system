<?php

namespace App\Models;

use App\Models\Attribute;
use App\Models\AttributeSetTranslation;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttributeSet extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    protected $fillable = [
        'display_layout',
        'sort',
        'status',
        'is_searchable',
        'feature',
        'created_by',
        'updated_by',
    ];

    protected $translationForeignKey = 'attributeSet_id';
    public $translatedAttributes = [
        'attributeSet_id',
        'locale',
        'title',
        'slug',

    ];


    public function trans()
    {
        return $this->hasMany(AttributeSetTranslation::class, 'attributeSet_id', 'id');
    }
    public function attribute()
    {
        return $this->hasMany(Attribute::class, 'attribute_set_id', 'id')->with('trans');
    }


}
