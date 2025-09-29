<?php

namespace App\Models;

use App\Enums\MenuPositionEnum;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menue extends Model
{
    use HasFactory, Translatable, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'position',
        'sort',
        'url',
        'type',
        'level',
        'dynamic_table',
        'dynamic_url',
        'status',
        'created_by',
        'updated_by',
    ];
    // foreign key  
    protected $translationForeignKey = 'menue_id';
    // transatable table
    public $translatedAttributes = ['menue_id', 'locale', 'title', 'slug'];


    public function trans(){
        return $this->hasMany(MenueTranslation::class, 'menue_id', 'id');
    }

    public function parent(){
        return $this->belongsTo(Menue::class,'parent_id', 'id');
    }
    public function children(){
        return $this->hasMany(Menue::class, 'parent_id', 'id');
    }


  
    // Scopes ------------------------------------------------
    public function scopeActive($query){
        return $query->where('status', 1);
    }
    public function scopeMain($query){
        return $query->where('position', MenuPositionEnum::MAIN);
    }
    // public function scopeSide($query){
    //     return $query->where('position', MenuPositionEnum::SIDE);
    // }
    public function scopeFooter($query){
        return $query->where('position', MenuPositionEnum::FOOTER);
    }
}
