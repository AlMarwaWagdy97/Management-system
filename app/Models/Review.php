<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'type',
        'description',
        'rate',
        'status',
        'reviewable_type',
        'reviewable_id',
        'created_by',
        'updated_by',
    ];

    public function reviewable()
    {
        return $this->morphTo();
    }
}
