<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(){
        return view('site.auth.login');
    }

    public function register(){
        return view('site.auth.register');
    }

    public function logout(){
        auth()->logout();
        return redirect(route('site.home'));
    }
}
