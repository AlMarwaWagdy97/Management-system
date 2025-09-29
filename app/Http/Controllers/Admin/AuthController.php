<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    public function showLogin(){
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request) {
        $request->authenticate();
        $request->session()->regenerate();
        return redirect()->route('admin.home');
    }

    
    public function logout(){
        auth()->logout();
        return redirect(route('admin.login'));
    }
}
