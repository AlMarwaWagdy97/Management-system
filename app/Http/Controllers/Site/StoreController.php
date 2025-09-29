<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Refer;
use Illuminate\Support\Facades\Cookie;

class StoreController extends Controller
{
    /**
     * @param mixed $slug
     * 
     * @return [type]
     */
    public function show($slug){
        
        if(is_numeric($slug)){
            $store = Refer::where('id', $slug)->active()->get()->first(); 
        }
        else{
            $store = Refer::where('slug', $slug)->active()->get()->first();
            if($store == null) { return redirect(route('site.home'));}
        }
        // save the store id in cookies and store in session
        Cookie::queue('referrer',  $store->id, 86400 * 30);
        $_SESSION['referrer'] = $store;

        return redirect(route('site.home'));
    }
}
