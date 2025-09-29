<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Volunteers extends Model
{
    use HasFactory, SoftDeletes;
    
  protected $fillable = [
        'account_id',
        'name',
        'identity',
        'mobile',
        'type',
        'team_logo',
        'team_name',
        'email',
        'nationality',
        'image',
        'gender',
        'medal',
        'working_hours',
        'effective',
        'activity',
        'status',
        'created_by',
        'updated_by',
        'date_of_birth',
        'educational_qualification',
        'preferred_fields',
        'preferred_times',
        'goal',
    ];

    public function account()
    {
        return $this->belongsTo(Accounts::class, 'account_id', 'id');
    }


    // SCOPE
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}









