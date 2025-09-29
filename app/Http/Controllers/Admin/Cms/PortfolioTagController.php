<?php

namespace App\Http\Controllers\Admin\Cms;

use Illuminate\Http\Request;
use App\Models\PortfolioTags;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\PortfolioTagRequest;

class PortfolioTagController extends Controller
{

    public function index(Request $request)
    {
        $query = PortfolioTags::query()->with('trans')->orderBy('id','DESC');
        if($request->status  != ''){
            $query->where('status', $request->status );
        }
        if($request->title  != ''){
            $query->orWhereTranslationLike('title','%'.$request->title.'%');
        }
        if($request->description != ''){
            $query->orWhereTranslationLike('description','%'.$request->title.'%');
        }
        $items = $query->paginate($this->pagination_count);
        return view('admin.dashboard.cms.portfolio-tags.index',compact('items'));
    }


    public function create()
    {
        return view('admin.dashboard.cms.portfolio-tags.create');
    }


    public function store(PortfolioTagRequest $request)
    {
        $data = $request->getSanitized();
        PortfolioTags::create($data);
        session()->flash('success' , trans('message.admin.created_sucessfully') );
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.portfolio-tags.index');
    }

    public function show(PortfolioTags $portfolioTag)
    {
        return view('admin.dashboard.cms.portfolio-tags.show',compact('portfolioTag'));   

    }


    public function edit(PortfolioTags $portfolioTag){
        return view('admin.dashboard.cms.portfolio-tags.edit',compact('portfolioTag'));   
    }


    public function update(PortfolioTagRequest $request, PortfolioTags $portfolioTag)
    {
        $data = $request->getSanitized();
        $portfolioTag->update($data);
        session()->flash('success' , trans('message.admin.updated_sucessfully') );
        if(request()->submit == "update"){ return  redirect()->back();}
        return redirect()->route('admin.portfolio-tags.index');   
    }


    public function destroy(PortfolioTags $portfolioTag)
    {
        $this->delete_file($portfolioTag->image);
        $this->delete_file($portfolioTag->background_image);
        $portfolioTag->delete();
        session()->flash('success' , trans('message.admin.deleted_sucessfully') );
        return redirect()->back();
    }


    //Method Update status
    public function update_status($id){
        $portfolioTag = PortfolioTags::findOrfail($id);
        $portfolioTag->status == 1 ? $portfolioTag->status = 0 : $portfolioTag->status = 1;
        $portfolioTag->save();
        return redirect()->back();
    }
    // Method Update Featured
    public function update_featured($id){
        $portfolioTag = PortfolioTags::findOrfail($id);
        $portfolioTag->feature == 1 ? $portfolioTag->feature = 0 : $portfolioTag->feature = 1;
        $portfolioTag->save();
        return redirect()->back();
    }

    // Method Update All Status And delete All
        // Delete All 

        public function actions(Request $request){
            if($request['publish'] == 1 ){
                $portfolioTags = PortfolioTags::findMany($request['record']);
                foreach ($portfolioTags as $portfolioTag){
                    $portfolioTag->update(['status' => 1]);
                }
                session()->flash('success' , trans('articles.status_changed_sucessfully') );
            }
            if($request['unpublish'] == 1 ){
                $portfolioTags = PortfolioTags::findMany($request['record']);
                foreach ($portfolioTags as $portfolioTag){
                    $portfolioTag->update(['status' => 0]);
                }
                session()->flash('success' , trans('articles.status_changed_sucessfully') );
            }
            if($request['delete_all'] == 1 ){
                $portfolioTags = PortfolioTags::findMany($request['record']);
                foreach ($portfolioTags as $portfolioTag){
                    $this->delete_file($portfolioTag->image);
                    $this->delete_file($portfolioTag->background_image);
                    $portfolioTag->delete();
                }
                session()->flash('success' , trans('pages.delete_all_sucessfully') );
            }
            return redirect()->back();
        }
}
