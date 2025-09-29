<?php

namespace App\Http\Controllers\Site\Referer;

use App\Http\Controllers\Controller;
use App\Models\OrderView;

class RefererController extends Controller
{
    public function index(){
        $refer = auth('account')->user()->referer;

        $orders = OrderView::where('refer_id', $refer->id)->get();
        return view('site.referer.index', compact( 'orders', 'refer'));
    }


    public function edit()
    {
        return view('site.referer.edit');
    }

    public function orders(){
        return view('site.referer.orders');
    }
}
