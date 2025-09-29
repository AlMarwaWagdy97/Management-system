<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckVendorAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(! auth('account')->check()){
            return redirect()->route('site.vendors.login');
        }
        if(auth('account')->user()?->types->where('type', 'vendor')->first() == null){
            return redirect()->route('site.vendors.login');
        }
        return $next($request);
    }
}
