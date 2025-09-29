<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentBank extends Model
{
    use HasFactory;
    protected $translationForeignKey = 'payment_method_id';
    protected $fillable = [
        'payment_method_id',
        'bank_name',
        'account_type',
        'iban',
        'payment_key',
        'bank_url',
        'image',
    ];

}
