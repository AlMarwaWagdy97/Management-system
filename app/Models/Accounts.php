<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Accounts extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;


    protected $fillable = [
        'user_name',
        'mobile',
        'email',
        'email_verified_at',
        'password',
        'image',
        'activation_code',
        'status',
        'login_date',
    ];

    public function types()
    {
        return $this->belongsToMany(LoginTypes::class, 'account_types', 'account_id', 'type_id');
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class, 'id', 'account_id');
        
    }
    public function cashier()
{
    return $this->hasOne(\App\Models\Cashier::class, 'account_id', 'id');
}
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'id', 'account_id');
    }

    public function referer()
    {
        return $this->belongsTo(Refer::class, 'id', 'account_id');
    }
    
    public function manager()
    {
        return $this->belongsTo(Manager::class, 'id', 'account_id');
    }

    public function substitute()
    {
        return $this->belongsTo(Substitutes::class, 'id', 'account_id');
    }

    // Scopes -----------------------------------------------------------------------------------
    public function scopeType($query, $arg)
    {
        return $query->whereHas('types', function($q) use ($arg){
        $q->where('login_types.type', $arg);

        });
    }
    public function scopeDonorType()
    {
        return $this->types->where('type', 'donor')->first();
    }
    public function scopeAdminType()
    {
        return $this->types->where('type', 'admin')->first();
    }
}
