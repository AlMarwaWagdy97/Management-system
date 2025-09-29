<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\LoginTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfDonorAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard("account")->check() && Auth::guard("account")->user()?->types->where('type', 'donor')->first() != null  && auth('account')->user()?->donor != null) {
            return redirect(route('site.profile.index'));
        }
        return $next($request);
    }
}
