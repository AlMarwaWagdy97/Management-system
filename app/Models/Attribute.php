<?php

namespace App\Models;

use App\Models\AttributeSet;
use App\Models\AttributeTranslation;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    protected $fillable = [
        'image',
        'sort',
        'status',
        'color',
        'attribute_set_id',
        'created_by',
        'updated_by',
    ];

    protected $translationForeignKey = 'attribute_id';
    public $translatedAttributes = [
        'attribute_id',
        'locale',
        'title',
        'slug',

    ];


    public function trans()
    {
        return $this->hasMany(AttributeTranslation::class, 'attribute_id', 'id');
    }

    public function attributeSet()
    {

        return $this->belongsTo(AttributeSet::class, 'attribute_set_id');
    }
}
