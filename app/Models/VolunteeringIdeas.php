<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VolunteeringIdeas extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'subject',
        'message',
        'status',
    ];

    public function comments(){
        return $this->hasMany(VoluntreerIdeaComments::class, 'idea_id', 'id');
    }

    public function activeComments(){
        return $this->hasMany(VoluntreerIdeaComments::class, 'idea_id', 'id')->where('status', 1);
    }

    public function loves(){
        return $this->hasMany(VoluntreerIdeaLoves::class, 'idea_id', 'id');
    }
    
    public function love_status(){
        return $this->hasMany(VoluntreerIdeaLoves::class, 'idea_id', 'id')->where('ip_address', request()->ip());
    }

    // Scopes ----------------------------
    public function scopeActive($query){
        return $query->where('status', 1);
    }
}
