<?php

namespace App\Enums;
 
class UrlTypesEnum extends Enum
{


    // public const TAG = 'tag';
    public const PAGES = 'pages';
    public const CATEGORIES = 'categories';
    public const PROJECTS = 'projects';
    public const CategoryBLOGS = 'category blogs';
    public const BLOGS = 'blogs';

    public const ALL_ARTICLES = 'all categories';
    public const ALL_CategoryBLOGS = 'all category blogs';
    public const ALL_BLOGS = 'all blogs';
    public const CONTACTUS = 'contact us';
    public const VOLUNTEERING = 'volunteering';
    public const BENEFICIARY = 'Beneficiary';


    public static function values() : array{

        return [
            static::PAGES => 'pages',
            static::CATEGORIES => 'categories',
            static::PROJECTS => 'projects',
            static::CategoryBLOGS => 'blogs',
            static::BLOGS => 'category blogs',

            static::ALL_ARTICLES => 'all categories',
            static::ALL_CategoryBLOGS => 'all category blogs',
            static::ALL_BLOGS => 'all blogs',
            static::CONTACTUS => 'contact us',
            static::VOLUNTEERING => 'volunteering',
            static::BENEFICIARY => 'Beneficiary',
        ];

    }


}
