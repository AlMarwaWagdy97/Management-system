<?php

namespace App\Http\Controllers\Site\Manager;

use App\Http\Controllers\Controller;
use App\Models\OrderView;

class ManagerController extends Controller
{
    public function index(){
        $manager = auth('account')->user()->manager;
        $orders = OrderView::whereIn('refer_id',$manager->refers->pluck('id')->toArray() ??[])->get();
        return view('site.manager.index', compact( 'orders', 'manager'));
    }


    public function edit()
    {
        return view('site.manager.edit');
    }

    public function orders(){
        return view('site.manager.orders');
    }
}
