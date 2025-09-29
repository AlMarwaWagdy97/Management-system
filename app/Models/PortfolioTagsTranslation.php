<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioTagsTranslation extends Model
{
    use HasFactory;
    protected $table = 'portfolio_tags_translations';
    protected $fillable = [
        'tag_id',
        'title',
        'slug',
        'locale',
     ];
}

