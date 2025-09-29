<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPayments extends Model
{
    use HasFactory;

    protected $table = 'birrukum.payment_methods';
}
