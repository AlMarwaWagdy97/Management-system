<?php

namespace App\Http\Controllers\Site\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Vendor\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('site.vendor.products.index');
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['category'] =  ProductCategory::with('trans')->active()->get('id');

        return view('site.vendor.products.create', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->upload_file($request->file('cover_image'), ('Products'));
        }
        $product = Product::create($data);

        session()->flash('success', trans('message.admin.created_sucessfully'));
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('site.vendors.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $data['product'] = $product;
        return view('site.vendor.products.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $data['product'] = $product;
        $data['category'] =  ProductCategory::with('trans')->active()->get();
        return view('site.vendor.products.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('cover_image')) {
            $this->delete_file($product->image);
            $data['cover_image'] = $this->upload_file($request->file('cover_image'), ('Products'));
        }

        $product->update($data);

        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if (request()->submit == "update") {  return  redirect()->back(); }
        return redirect()->route('site.vendors.products.index');

    }


}
