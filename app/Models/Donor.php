<?php

namespace App\Models;

use App\Models\AddressDonor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Donor extends Authenticatable
{
    use  HasApiTokens, HasFactory, SoftDeletes;



    public $fillable = [
        'account_id',
        'refer_id',
        'full_name',
        'mobile',
        'mobile_confirm',
        'identity',
        'otp',
        'token',
        'image',
        'expiration',
        'status',
        'created_by',
        'updated_by',

    ];
    public function addressDonor()
    {
        return $this->hasMany(AddressDonor::class, 'doner_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo(Accounts::class, 'account_id', 'id');
    }

    public function refer()
    {
        return $this->belongsTo(Refer::class, 'refer_id', 'id');
    }

    public function cards()
    {
        return $this->hasMany(CreditCard::class, 'donor_id', 'id')->where('status', 1);
    }


    public function orders()
    {
        return $this->hasMany(Order::class, 'donor_id');
    }

    public function scopeForMonth($query, $year, $month)
    {
        $start = Carbon::createFromDate($year, $month, 1);
        $end = $start->copy()->endOfMonth();
        return $query->whereBetween('created_at', [$start, $end]);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'donor_id')
        ;
    }
}