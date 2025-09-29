<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'name',
        'status',
    ];


    public function account()
    {
        return $this->belongsTo(Accounts::class, 'account_id', 'id');
    }

    public function refers()
    {
        return $this->belongsToMany(Refer::class, 'manager_refers', 'manager_id', 'refer_id');
    }

}
