<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodTranslation extends Model
{
    use HasFactory;
    protected $table = 'payment_method_translations';
    protected $fillable = ['payment_id','title','content','locale'];
}
