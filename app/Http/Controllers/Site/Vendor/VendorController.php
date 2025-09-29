<?php

namespace App\Http\Controllers\Site\Vendor;

use App\Enums\ShippingStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Http\Request;

class VendorController extends Controller
{

    public function index(){
        $vendor = auth('account')->user()->vendor;

        $orders = OrderDetails::where('vendor_id', $vendor->id)
        ->whereHas('order', function($q){
            return $q->where('status', 1);
        })->where('shipping_status', ShippingStatusEnum::DELIVERED)->get();

        $products = Product::where('vendor_id', $vendor->id)->get();

        return view('site.vendor.index', compact('vendor', 'orders', 'products'));
    }


    public function edit()
    {
        return view('site.vendor.edit');
    }

    public function orders(){
        return view('site.vendor.orders');
    }
}
