<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ritestranslation extends Model
{
    use HasFactory;
    protected $table = 'ritestranslations';

    protected $fillable = [
        'rites_id',
        'title',
        'locale',
    ];
}
