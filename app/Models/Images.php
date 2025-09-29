<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'url',
        'sort',
        'status',
        'image_type',
        'parentable_type',
        'parentable_id',

    ];

    // relations ---------------------------------------------------------------------------------
    public function parentable(){
        return $this->morphTo();
    }
}
