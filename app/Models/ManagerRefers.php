<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerRefers extends Model
{
    use HasFactory;

    protected $fillable = [
        'manager_id',
        'refer_id',
    ];

    public function manager(){
        return $this->belongsTo(Manager::class);
    }

    public function refer(){
        return $this->belongsTo(Refer::class);
    }
}
