<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\NewsRequest;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::query()->with('trans')->orderBy('id', 'DESC');


    
        if($request->status  != ''){
            $query->where('status', $request->status );
        }
        if ($request->title  != '') {
    
            $query = $query->orWhereTranslationLike('title', '%' . request()->input('title') . '%');
        }
   
        if($request->description != ''){
            $query = $query->orWhereTranslationLike('description', '%' . request()->input('description') . '%');

        }
        $items = $query->paginate($this->pagination_count);
        return view('admin.dashboard.cms.news.index', compact('items'));
    }

    public function create()
    {
        return view('admin.dashboard.cms.news.create');
    }


    public function store(NewsRequest $request)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('news'));
        }
        News::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.news.index');
    }


    public function show(News $news)
    {
        return view('admin.dashboard.cms.news.show', compact('news'));
    }


    public function edit(News $news)
    {
        return view('admin.dashboard.cms.news.edit', compact('news'));
    }


    public function update(NewsRequest $request, News $news)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $this->delete_file($news->image);
            $data['image'] = $this->upload_file($request->file('image'), ('news'));
        }
        $news->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if(request()->submit == "update"){ return  redirect()->back();}
        return redirect()->route('admin.news.index'); 
    }


    public function destroy(News $news)
    {
        $this->delete_file($news->image);
        $news->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    public function update_status($id)
    {
        $news = News::findOrfail($id);
        $news->status == 1 ? $news->status = 0 : $news->status = 1;
        $news->save();
        return redirect()->back();
    }

    public function update_featured($id)
    {
        $news = News::findOrfail($id);
        $news->feature == 1 ? $news->feature = 0 : $news->feature = 1;
        $news->save();
        return redirect()->back();
    }



    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $news = News::findMany($request['record']);
            foreach ($news as $new) {
                $new->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $news = News::findMany($request['record']);
            foreach ($news as $new) {
                $new->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $news = News::findMany($request['record']);
            foreach ($news as $new) {
                $this->delete_file($new->image);
                $new->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
