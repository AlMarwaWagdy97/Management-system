<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * Display the  resource.
     */
    public function index()
    {
        return view('site.pages.cart');
    }
}
