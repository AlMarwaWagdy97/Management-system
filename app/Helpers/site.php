<?php

use App\Models\Pages;
use Illuminate\Support\Facades\Crypt;

if (!function_exists('site_path')) {
    function site_path($path)
    {
        return asset("storage/site/" . $path);
    }
}


if (!function_exists('orderIdentifier')) {
    function orderIdentifier($val = null) {
        $result =    (((0x0000FFFF & $val) << 16) + ((0xFFFF0000 & $val) >> 16));
        return $result;

    }
}

if (!function_exists('getOrderId')) {
    function getOrderId($val = null) {
        if(str_contains($val, 'AUTH3_'))$val = str_replace("AUTH3_", "", $val);
        $result1 =    ((0x0000FFFF | $val) >> 16 ) ;
        return  $result1;

    }
}




/**
 * encrypt small data ex [cvv, expired year & monuth, ...]
 *
 * @param integer $val
 * @return string
 */
if (!function_exists('encrypt')) {
    function encrypt($val = null) {
        return ( (0x0000FFFF & $val) << 48) + ((0xFFFF0000 & $val) >> 48 );
    }
}


/**
 * decrypt small data ex [cvv, expired year & monuth, ...]
 *
 * @param string $string
 * @return string
 */
if (!function_exists('decrypt')) {
    function decrypt($val = null) {
        $res = ( (0x0000FFFF | $val) >> 48);
        if(strlen($res) == 1) $res = '0' . $res;
        return  $res;
    }
}


