<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Tag;
use App\Models\Articles;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\ArticlesRequest;

class ArticlesContoller extends Controller
{
    public function index(Request $request)
    {
        $query = Articles::query()->with('trans', 'categories', 'tags')->orderBy('id', 'DESC');

    
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
        return view('admin.dashboard.cms.articles.index', compact('items'));
    }

    public function create()
    {
        // $tags = Tag::query()->with('trans')->get();
        $categories = Categories::query()->with('trans')->get();
        return view('admin.dashboard.cms.articles.create',compact('categories'));
    }


    public function store(ArticlesRequest $request)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('articles'));
        }

        $articles= Articles::create($data);
        // if(request()->tags != null){
        //     $articles->tags()->attach(request()->tags );
        // }
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.articles.index');

    }


    public function show(Articles $article)
    {
        return view('admin.dashboard.cms.articles.show', compact('article'));
    }


    public function edit(Articles $article)
    {
        // $tags = Tag::query()->with('trans')->get();
        $categories = Categories::query()->with('trans')->get();
        return view('admin.dashboard.cms.articles.edit', compact('article','categories'));
    }


    public function update(ArticlesRequest $request, Articles $article)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $this->delete_file($article->image);
            $data['image'] = $this->upload_file($request->file('image'), ('articles'));
        }
        $article->update($data);
        // if(request()->tags != null){
        //     $article->tags()->sync(request()->tags);
        // }
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if(request()->submit == "update"){ return  redirect()->back();}
        return redirect()->route('admin.articles.index');  
    }


    public function destroy(Articles $article)
    {
        $this->delete_file($article->image);
        $article->delete();
        $article->tags()->detach();

        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    public function update_status($id)
    {
        $article = Articles::findOrfail($id);
        $article->status == 1 ? $article->status = 0 : $article->status = 1;
        $article->save();
        return redirect()->back();
    }

    public function update_featured($id)
    {
        $article = Articles::findOrfail($id);
        $article->feature == 1 ? $article->feature = 0 : $article->feature = 1;
        $article->save();
        return redirect()->back();
    }



    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $articles = Articles::findMany($request['record']);
            foreach ($articles as $article) {
                $article->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $articles = Articles::findMany($request['record']);
            foreach ($articles as $article) {
                $article->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $articles = Articles::findMany($request['record']);
            foreach ($articles as $article) {
                $this->delete_file($article->image);
                $article->delete();
                $article->tags()->detach();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
