<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Themes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check() && Auth::guard($guard)->user()?->types->where('type', 'admin')->first() != null) {
                return redirect(route('admin.home'));
            }
        }

        // $theme = Themes::query();
        // $adminLoginTheme = json_decode((clone @$theme)->loginDashboard()->get()->first()? (clone @$theme)->loginDashboard()->get()->first()->value: '');
        // view()->share('adminLoginTheme' , $adminLoginTheme);

        return $next($request);
    }
}
