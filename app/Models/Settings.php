<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;


    protected $fillable = ['key', 'status'];

    //  Relations 
    public function values()
    {
        return $this->hasMany(SettingsValues::class, 'setting_id', 'id');
    }


    //  Mutators & Casting 
    /**
     * @return mixed
     */
    public function getTitleAttribute()
    {
        return @$this->values->where('key', 'title')->first()?->value ?? trans('settings.' . $this->key);
    }
    //  End Mutators & Casting 


    // Scopes ----------------------------
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

}
