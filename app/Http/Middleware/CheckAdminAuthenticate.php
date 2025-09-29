<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Themes;
use Illuminate\Http\Request;

class CheckAdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
     
        if(! auth('account')->check()){
            return redirect()->route('admin.login');
        }
        if(auth('account')->user()?->types->where('type', 'admin')->first() == null){
            return redirect()->route('admin.login');
        }
        if(auth('account')->user()?->AdminType() == null){
            return redirect()->route('admin.login');
        }
        if(@auth('account')->user()->status != 1){
            auth()->logout();
            session()->flash('error' , trans('message.admin.account_not_active') );
            return redirect()->route('admin.login');
        }
        return $next($request);
    
    }
}
