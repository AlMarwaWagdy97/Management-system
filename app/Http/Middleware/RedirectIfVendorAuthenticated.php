<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfVendorAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard("account")->check() && Auth::guard("account")->user()?->types->where('type', 'vendor')->first() != null && 
        Auth::guard("account")->user()?->vendor->status == 1) {
            return redirect(route('site.vendors.index'));
        }
        return $next($request);
    }
}
