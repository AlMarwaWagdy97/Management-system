<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\CMS\SliderStoreRequest;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $q = Slider::query()->with('trans')->orderBy('id', 'DESC');

           if($request->title != null){
            
             $q->orWhereTranslationLike('title','%'.$request->title.'%');
        }
        
        $sliders = $q->paginate($this->pagination_count);
        return view('admin.dashboard.cms.slider.index',compact('sliders'));  

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dashboard.cms.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderStoreRequest $request)
    {
        $data = $request->getSanitized();
        
        if($request->hasFile('image')){
            $data['image'] = $this->upload_file($request->file('image') , ('slider'));
        }
        if($request->hasFile('mobile_image')){
            $data['mobile_image'] = $this->upload_file($request->file('mobile_image') , ('slider'));
        }

        Slider::create($data);
        session()->flash('success' , trans('message.admin.created_sucessfully') );
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.slider.index');

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        return view('admin.dashboard.cms.slider.show',compact('slider'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return view('admin.dashboard.cms.slider.edit',compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SliderStoreRequest $request, Slider $slider)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $this->delete_file($slider->image);
            $data['image'] = $this->upload_file($request->file('image'), ('slider'), 1);
        }
        if ($request->hasFile('mobile_image')) {
            $this->delete_file($slider->mobile_image);
            $data['mobile_image'] = $this->upload_file($request->file('mobile_image'), ('slider'), 2);
        }
        $slider->update($data);
       session()->flash('success' , trans('message.admin.updated_sucessfully') );
       if(request()->submit == "update"){ return  redirect()->back();}
        return redirect()->route('admin.slider.index');
    }

    // Updated Status

    public function update_status($id){
        $article = Slider::findOrfail($id);
        $article->status == 1 ? $article->status = 0 : $article->status = 1;
        $article->save();
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $this->delete_file($slider->image);
        $this->delete_file($slider->mobile_image);
        $slider->delete();
        session()->flash('success' , trans('message.admin.deleted_sucessfully') );
        return redirect()->back();
    }

    // Delete All 

    public function actions(Request $request){
        if($request['publish'] == 1 ){
            $sliders = Slider::findMany($request['record']);
            foreach ($sliders as $slider){
                $slider->update(['status' => 1]);
            }
            session()->flash('success' , trans('articles.status_changed_sucessfully') );
        }
        if($request['unpublish'] == 1 ){
            $sliders = Slider::findMany($request['record']);
            foreach ($sliders as $slider){
                $slider->update(['status' => 0]);
            }
            session()->flash('success' , trans('articles.status_changed_sucessfully') );
        }
        if($request['delete_all'] == 1 ){
            $sliders = Slider::findMany($request['record']);
            foreach ($sliders as $slider){
                $this->delete_file($slider->image);
                $this->delete_file($slider->mobile_image);
                $slider->delete();
            }
            session()->flash('success' , trans('pages.delete_all_sucessfully') );
        }
        return redirect()->back();
    }
}
