<?php

namespace App\Http\Controllers\Cashier\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CashierAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('cashier.auth.login');
    }

 public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $credentials = $request->only('email', 'password');

    
    if (Auth::guard('cashier')->attempt($credentials, $request->boolean('remember'))) {
        $user = Auth::guard('cashier')->user();

        
        
        if (! $user->cashier) {
            
            Auth::guard('cashier')->logout();
            throw ValidationException::withMessages([
                'email' => ['هذا الحساب غير مسجل  .'],
            ]);
        }

        $request->session()->regenerate();

        
        return redirect()->intended(route('site.cashier.home'));
    }

    throw ValidationException::withMessages([
        'email' => [trans('auth.failed')],
    ]);
}
    public function logout(Request $request)
    {
        Auth::guard('cashier')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('site.cashier.login');
    }
}
