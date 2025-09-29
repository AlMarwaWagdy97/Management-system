<?php

namespace App\Http\Controllers\Site\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagerAuthController extends Controller
{
    public function login(){
        return view('site.manager.auth.login');
    }

   
    public function logout(){
        auth()->logout();
        return redirect(route('site.managers.home'));
    }
}
