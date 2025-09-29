<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TrackingOrderController extends Controller
{
    public function trackingOrder($id)
    {
        $order = Order::with('details')->findOrFail($id);
        $products = $order->details->where('item_type', 'App\Models\Product');
        if($products->count() == 0){ abort('404'); }
        return view('site.pages.tracking-order', compact('order', 'products'));
    }
}
