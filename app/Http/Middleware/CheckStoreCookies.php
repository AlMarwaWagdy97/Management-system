<?php

namespace App\Http\Middleware;

use App\Models\Refer;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;

class CheckStoreCookies
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $refer = Refer::find(Cookie::get('referrer'));
        // if refer status is false unset the referrer
        if(isset($refer) && $refer->status != 1 || Cookie::get('referrer') == null ){
            Cookie::queue('referrer',  null);
            Cookie::queue(Cookie::forget('referrer'));
            $_SESSION['referrer'] = null;
        }

        if( (Cookie::get('referrer') != null) && !isset($_SESSION['referrer'])){
            $_SESSION['referrer'] =  $refer;
        }

       

        return $next($request);
    }
}
