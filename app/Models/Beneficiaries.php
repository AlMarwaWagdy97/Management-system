<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Beneficiaries extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'account_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'nationality',
        'marital_status',
        'phone',
        'date_of_birth',
        'family_members',
        'education_level',
        'city',
        'district',
        'id_number',
        'civil_register',
        'email',
        'housing_status',
        'job_type',
        'monthly_income',
        'previous_registration',
        'chronic_diseases',
        'special_needs',
        'other_income',
        'additional_notes',
        'status',
        'created_by',
        'updated_by',
    ];

    public function account()
    {
        return $this->belongsTo(Accounts::class, 'account_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}