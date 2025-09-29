<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\OrderView;

class ProfileController extends Controller
{

    public function index()
    {
        $donor = auth('account')->user()->donor;
        $orders = OrderView::where('donor_id', $donor->id)->get();
        return view('site.profile.index', compact('donor', 'orders'));
    }

    public function edit()
    {
        return view('site.profile.edit');
    }

    public function close()
    {
        $donor = auth('account')->user()->donor; 
        auth('account')->logout();
        $donor->delete();
        return redirect()->route('site.login');
    }

    
    public function orders()
    {
        return view('site.profile.orders');
    }
    
    public function gifts()
    {
        return view('site.profile.gifts');
    }


    public function statistics()
    {
        return view('site.profile.statistics');
    }
}
