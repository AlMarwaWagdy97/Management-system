<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $table = 'domains';

    protected $fillable = [
        'domain_name',
        'domain_url',
        'status',
        'token',
        'type', // zid | holol
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
