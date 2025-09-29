<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfManagerAuthenticated
{
         /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard("account")->check() && Auth::guard("account")->user()?->types->where('type', 'manager')->first() != null && 
        Auth::guard("account")->user()?->manager?->status == 1) {
            return redirect(route('site.managers.index'));
        }
        return $next($request);
    }
}
