<?php

namespace App\Http\Controllers\Site\Vendor;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(){
        return view('site.vendor.auth.login');
    }

   
    public function logout(){
        auth()->logout();
        return redirect(route('site.vendors.home'));
    }
}
