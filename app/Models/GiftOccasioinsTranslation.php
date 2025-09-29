<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftOccasioinsTranslation extends Model
{
    use HasFactory;


    protected $table = 'gift_occasioins_translations';
    
    protected $fillable = [
        'occasioin_id',
        'title',
        'locale',
    ];
}
