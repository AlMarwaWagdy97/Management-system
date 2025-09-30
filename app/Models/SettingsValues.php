<?php

namespace App\Models;

use App\Models\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SettingsValues extends Model
{
    use HasFactory;


    protected $fillable = ['setting_id', 'key', 'value', 'type'];

    public function setting(){
        return $this->belongsTo(Settings::class, 'setting_id');
    }

}
