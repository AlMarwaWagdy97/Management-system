<?php

namespace App\Http\Controllers\Admin\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\App\AppSectionRequest;
use App\Models\AppSection;
use Illuminate\Http\Request;

class AppSectionController extends Controller
{
    public function index(Request $request)
    {
        $query = AppSection::query()->with('trans')->orderBy('id', 'DESC');

    
        if($request->status  != ''){
            if( $request->status == 1) $query->where('status', $request->status );
            else{  $query->where('status', '!=', 1); }
        }
        if ($request->title  != '') {
            $query = $query->orWhereTranslationLike('title', '%' . request()->input('title') . '%');
        }
   
        if($request->description != ''){
            $query = $query->orWhereTranslationLike('description', '%' . request()->input('description') . '%');

        }
        $items = $query->paginate($this->pagination_count);
        return view('admin.dashboard.app.sections.index', compact('items'));
    }

    public function create()
    {
        return view('admin.dashboard.app.sections.create');
    }


    public function store(AppSectionRequest $request)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('appsection'));
        }

        $sections= AppSection::create($data);
       
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.app.sections.index');

    }


    public function show(AppSection $section)
    {
        return view('admin.dashboard.app.sections.show', compact('section'));
    }


    public function edit(AppSection $section)
    {
        return view('admin.dashboard.app.sections.edit', compact('section'));
    }


    public function update(AppSectionRequest $request, AppSection $section)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $this->delete_file($section->image);
            $data['image'] = $this->upload_file($request->file('image'), ('appsection'));
        }
        $section->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if(request()->submit == "update"){ return  redirect()->back();}
        return redirect()->route('admin.app.sections.index');  
    }


    public function destroy(AppSection $section)
    {
        $this->delete_file($section->image);
        $section->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    public function update_status($id)
    {
        $section = AppSection::findOrfail($id);
        $section->status == 1 ? $section->status = 0 : $section->status = 1;
        $section->save();
        return redirect()->back();
    }

    public function update_featured($id)
    {
        $section = AppSection::findOrfail($id);
        $section->feature == 1 ? $section->feature = 0 : $section->feature = 1;
        $section->save();
        return redirect()->back();
    }



    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $sections = AppSection::findMany($request['record']);
            foreach ($sections as $section) {
                $section->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $sections = AppSection::findMany($request['record']);
            foreach ($sections as $section) {
                $section->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $sections = AppSection::findMany($request['record']);
            foreach ($sections as $section) {
                $this->delete_file($section->image);
                $section->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
