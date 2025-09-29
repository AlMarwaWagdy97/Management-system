<?php

namespace App\Http\Controllers\Site\Referer;

use App\Http\Controllers\Controller;

class RefererAuthController extends Controller
{
    public function login(){
        return view('site.referer.auth.login');
    }

   
    public function logout(){
        auth()->logout();
        return redirect(route('site.referer.home'));
    }
}
