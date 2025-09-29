<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoluntreerIdeaLoves extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'idea_id',
        'ip_address',
    ];

    public function idea()
    {
        return $this->belongsTo(VolunteeringIdeas::class, 'idea_id', 'id');
    }
}
