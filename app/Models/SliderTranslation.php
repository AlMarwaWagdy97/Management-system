<?php

namespace App\Models;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SliderTranslation extends Model
{
    use HasFactory;
    protected $table = 'slider_translations';

    protected $fillable = [
        'slider_id',
        'locale',
        'title',
        'slug',
        'description',
    ];


    public function main(){
        return $this->belongsTo(Slider::class, 'id', 'slider_id');
    }
}
