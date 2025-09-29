<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\OrderDetails;
use Illuminate\Http\Request;

class ReviewOrderController extends Controller
{

    public function reviewProduct($id){
        $orderDetail = OrderDetails::with('item')->findOrFail($id);
        if($orderDetail->rate != null){
            session()->flash('warning' , trans('Already Rated') );
            return redirect()->route('site.home');
        }
        
        return view('site.pages.reviews.review-products', compact('orderDetail'));
    }



    public function submitReview(Request $request){

        $orderDetail = OrderDetails::with('item')->findOrFail($request->id);
        $orderDetail->rate = $request->rate;
        $orderDetail->review = $request->review;
        $orderDetail->save();

        session()->flash('success' , trans('Review is submitted successfully') );
        return redirect()->route('site.home');
    }
}
