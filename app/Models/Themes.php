<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Themes extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'created_by',
        'updated_by',
    ];

// Scopes ----------------------------
    public function scopeDashboard($query){
        return $query->where('key','dashboard');
    }
    public function scopeLoginDashboard($query){
        return $query->where('key','login_dashboard');
    }
    public function scopeSite($query){
        return $query->where('key','site');
    }
}
