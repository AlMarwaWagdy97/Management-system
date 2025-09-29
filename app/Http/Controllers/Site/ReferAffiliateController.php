<?php

namespace App\Http\Controllers\Site;

use App\Models\Refer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;

class ReferAffiliateController extends Controller
{
    public function index($code)
    {
        $refer = Refer::where('code', $code)->first();

        if (!$refer) {
            return redirect()->route('site.home'); 
        }

      
        

     
        $minutes = 60 * 24 * 30;
        $cookie = cookie('refer', json_encode([
            'id' => $refer->id,
            'code' => $refer->code,
        ]), $minutes, null, null, app()->isProduction(), true, false, 'Lax');

        return redirect()->route('site.home')->withCookie($cookie);
    }
}
