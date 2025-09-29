<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Decease extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'confirm_mobile',
        'image',
        'target_price',
        'description',
        'deceased_name',
        'relative_relation',
        'deceased_image',
        'status',
        'confirmed',
        'project_id',
        'created_by',
        'updated_by',
    ];


    // relation

    public function project(){
        return $this->belongsTo(CharityProject::class,'project_id');
    }
}
