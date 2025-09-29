<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Substitutes extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'account_id',
        'full_name',
        'identity',
        'nationality',
        'gender',
        'image',
        'languages',
        'proportion',
        'status',
    ];


    public function types()
    {
        return $this->belongsToMany(LoginTypes::class, 'account_types', 'account_id', 'type_id');
    }

    public function account()
    {
        return $this->belongsTo(Accounts::class, 'account_id', 'id');
    }


    // Scopes ----------------------------
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
