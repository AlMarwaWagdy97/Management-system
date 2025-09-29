<?php

namespace App\Enums;
 
class SourcesEnum extends Enum
{


    public const WEB = 'web';
    public const APP = 'app';
    public const BADAL = 'badal';

    public static function values() : array{
        return [
            static::WEB => 'web',
            static::APP => 'app',
            static::BADAL => 'badal',
        ];
    }

}
