<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSettingPageTranslation extends Model
{
    use HasFactory;
    protected $table = 'home_setting_page_translations';
    protected $fillable = [
        'home_setting_id',
        'title',
        'description',
        'locale',
     ];

}
