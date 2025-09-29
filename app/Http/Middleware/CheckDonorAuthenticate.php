<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDonorAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(! auth('account')->check()){
            return redirect()->route('site.login');
        }
        if(auth('account')->user()?->types->where('type', 'donor')->first() == null || auth('account')->user()?->donor == null){
            return redirect()->route('site.login');
        }
        // if(@auth('account')->user()->status != 1){
        //     auth()->logout();
        //     session()->flash('error' , trans('message.admin.account_not_active') );
        //     return redirect()->route('site.login');
        // }
        return $next($request);
    }
}
