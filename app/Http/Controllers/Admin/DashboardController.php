<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardServices;
use Illuminate\Support\Facades\Cookie;


class DashboardController extends Controller
{
    public function home(){
       
        $data = (new DashboardServices())->index();

        return view('admin.dashboard.index', $data);


    }

    public function switchMode(){
        Cookie::queue(Cookie::forget('color-side'));
        Cookie::queue(Cookie::forget('color-header'));
        Cookie::queue('mode', request()->mode , 60 * 24 * 365);
        $mode = Cookie::get('mode');
        return $mode;
    }

    public function updateColorHeader(){
        if(request()->color == "reset"){
            Cookie::queue(Cookie::forget('color-header'));
            $mode =  Cookie::get('color-header');
        }
        else{
            Cookie::queue('color-header', request()->color , 60 * 24 * 365);
            $mode = Cookie::get('color-header');
        }
        return $mode;
    }

    public function updateColorSide(){
        if(request()->color == "reset"){
            Cookie::queue(Cookie::forget('color-side'));
            Cookie::queue(Cookie::forget('color-header'));
            $mode =  Cookie::get('color-side');
        }
        else{
            Cookie::queue('color-side', request()->color , 60 * 24 * 365);
            $mode = Cookie::get('color-sider');
        }
        Cookie::queue(Cookie::forget('mode'));
        return $mode;
    }

    public function fetchStoreStatistics(){
        $storeApiService = new \App\Services\Admin\StoreApiService();
        
        $startDate = request('start_date');
        $endDate = request('end_date');
        
        $statistics = $storeApiService->fetchAllStoresStatistics($startDate, $endDate);
        
        return response()->json([
            'success' => true,
            'message' => 'Statistics fetched successfully',
            'data' => $statistics
        ]);
    }
}
