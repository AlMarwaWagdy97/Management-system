<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftsCardOccasions extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_id',
        'occasioin_id',
    ];

    

    // relations -------------------------------------------------------
    public function card()
    {
        return $this->belongsTo(GiftCards::class, 'id', 'card_id');
    }
    
    public function occasioin()
    {
        return $this->belongsTo(GiftOccasioins::class, 'id', 'occasioin_id');
    }

    
}
