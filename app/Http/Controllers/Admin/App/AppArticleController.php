<?php

namespace App\Http\Controllers\Admin\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\App\AppArticleRequest;
use App\Models\AppArticles;
use App\Models\AppSection;
use Illuminate\Http\Request;

class AppArticleController extends Controller
{

    public function index(Request $request)
    {
        $query = AppArticles::query()->with('trans', 'section')->orderBy('id', 'DESC');

    
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
        return view('admin.dashboard.app.articles.index', compact('items'));
    }

    public function create()
    {
        $sections = AppSection::query()->with('trans')->get();
        return view('admin.dashboard.app.articles.create',compact('sections'));
    }


    public function store(AppArticleRequest $request)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('apparticles'));
        }

        $articles= AppArticles::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.app.articles.index');

    }


    public function show(AppArticles $article)
    {
        return view('admin.dashboard.app.articles.show', compact('article'));
    }


    public function edit(AppArticles $article)
    {
        $sections = AppSection::query()->with('trans')->get();
        return view('admin.dashboard.app.articles.edit', compact('article', 'sections'));
    }


    public function update(AppArticleRequest $request, AppArticles $article)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $this->delete_file($article->image);
            $data['image'] = $this->upload_file($request->file('image'), ('apparticles'));
        }
        $article->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if(request()->submit == "update"){ return  redirect()->back();}
        return redirect()->route('admin.app.articles.index');  
    }


    public function destroy(AppArticles $article)
    {
        $this->delete_file($article->image);
        $article->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    public function update_status($id)
    {
        $article = AppArticles::findOrfail($id);
        $article->status == 1 ? $article->status = 0 : $article->status = 1;
        $article->save();
        return redirect()->back();
    }

    public function update_featured($id)
    {
        $article = AppArticles::findOrfail($id);
        $article->feature == 1 ? $article->feature = 0 : $article->feature = 1;
        $article->save();
        return redirect()->back();
    }



    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $articles = AppArticles::findMany($request['record']);
            foreach ($articles as $article) {
                $article->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $articles = AppArticles::findMany($request['record']);
            foreach ($articles as $article) {
                $article->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $articles = AppArticles::findMany($request['record']);
            foreach ($articles as $article) {
                $this->delete_file($article->image);
                $article->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
