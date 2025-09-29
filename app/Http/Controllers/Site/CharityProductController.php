<?php

namespace App\Http\Controllers\Site;

use App\Charity\Settings\SettingSingleton;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CharityProductController extends Controller
{
    /**
     * show the all products.
     */
    public function index(Request $request)
    {
        $settings = SettingSingleton::getInstance();
        return view('site.pages.charity-product.index', compact('settings'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        if (is_numeric($id)) {
            $product = Product::active()->findOrFail($id);
        } else {
            $product = Product::active()->with(['trans', 'Category', 'Category.trans'])->whereHas('trans', function ($q) use ($id) {
                $q->where('slug', $id);
            })->first();
            if ($product == null) abort('404');
        }
        $settings = SettingSingleton::getInstance();


        return view('site.pages.charity-product.show', compact('product', 'settings'));
    }
}
