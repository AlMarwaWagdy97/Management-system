<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class BeneficiariesController extends Controller
{
    public function index()
    {
        return view('site.beneficiaries.index');
    }

    public function joinCommunity()
    {
        return view('site.beneficiaries.join-community');
    }
}
