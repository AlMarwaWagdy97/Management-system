<?php

namespace App\Http\Controllers\Site;

use App\Charity\Settings\SettingSingleton;
use App\Models\Slider;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;


class HomeController extends Controller
{
    public function index()
    {
        
        $cookieValue = Cookie::get('cart');
        if(!$cookieValue){
            $token = Str::random(32); // Adjust the length as needed
            $cookieValue = Cookie::queue('cart', $token, 60 * 24 * 365);
        }
        
        return view('site.pages.index');
    }
}
