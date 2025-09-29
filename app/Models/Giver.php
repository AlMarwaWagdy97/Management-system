<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Giver extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'order_id',
        'category_id',
        'occasioin_id',
        'category_name',
        'occasioin_name',
        'card_id',
        'image',

        'name',
        'mobile',
        'email',
        'address',
        'message',
        'status',
    ];

    public function order(){
        return $this->belongsTo(OrderDetails::class);
    }
    
    public function card(){
        return $this->belongsTo(GiftCards::class, 'card_id', 'id');
    }

}
