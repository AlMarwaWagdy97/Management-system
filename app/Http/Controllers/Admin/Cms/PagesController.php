<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Pages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\PageRequest;

class PagesController extends Controller
{
    
    public function index()
    {
        $query = Pages::query()->with('trans')->orderBy('id', 'DESC');
        if(request()->input('title')  != ''){
            $query = $query->WhereTranslationLike('title', '%' . request()->input('title') . '%');
        }
        $items = $query->paginate($this->pagination_count);

        return view('admin.dashboard.cms.pages.index', compact('items'));
    }

    public function create()
    {
        return view('admin.dashboard.cms.pages.create');
    }


    public function store(PageRequest $request)
    {
        $data =$request->getSanitized();
        if($request->hasFile('image')){
            $data['image'] = $this->upload_file($request->file('image') , ('pages'));
        }
        Pages::create($data);
        session()->flash('success' , trans('message.admin.created_sucessfully') );
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.pages.index');
    }


    public function show( Pages $page)
    {
        return view('admin.dashboard.cms.pages.show' , compact('page'));
    }


    public function edit( Pages $page)
    {
        return view('admin.dashboard.cms.pages.edit' , compact('page'));
    }


    public function update(PageRequest $request, Pages $page)
    {
        $data =$request->getSanitized();
        if ($request->hasFile('image')) {
            $this->delete_file($page->image);
            $data['image'] = $this->upload_file($request->file('image'), ('pages'));
        }
        $page->update($data);
        session()->flash('success' , trans('message.admin.updated_sucessfully') );
        if(request()->submit == "update"){ return  redirect()->back();}
        return redirect()->route('admin.pages.index');
    }


    public function destroy(Pages $page)
    {
        $this->delete_file($page->image);
        $page->delete();
        session()->flash('success' , trans('message.admin.deleted_sucessfully') );
        return redirect()->back();
    }


    public function update_status($id){
        $page = Pages::findOrfail($id);
        $page->status == 1 ? $page->status = 0 : $page->status = 1;
        $page->save();
        return redirect()->back();
    }

    public function actions(Request $request){
        if($request['publish'] == 1 ){
            $pages = Pages::findMany($request['record']);
            foreach ($pages as $page){
                $page->update(['status' => 1]);
            }
            session()->flash('success' , trans('pages.status_changed_sucessfully') );
        }
        if($request['unpublish'] == 1 ){
            $pages = Pages::findMany($request['record']);
            foreach ($pages as $page){
                $page->update(['status' => 0]);
            }
            session()->flash('success' , trans('pages.status_changed_sucessfully') );
        }
        if($request['delete_all'] == 1 ){
            $pages = Pages::findMany($request['record']);
            foreach ($pages as $page){
                $this->delete_file($page->image);
                $page->delete();
            }
            session()->flash('success' , trans('pages.delete_all_sucessfully') );
        }
        return redirect()->back();
    }

}
