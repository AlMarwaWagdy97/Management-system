<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Portfolios;
use Illuminate\Http\Request;
use App\Models\PortfolioTags;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\PortfolioRequest;

class PortfolioController extends Controller
{
    public $tags;

    public function __construct()
    {
        $this->tags = PortfolioTags::query()->with('trans')->get();
    }
    
    public function index(Request $request)
    {

        $query = Portfolios::query()->with('trans', 'tag')->orderBy('id', 'DESC');
        $tags = $this->tags;
    
        if($request->status  != ''){
            if( $request->status == 1) $query->where('status', $request->status );
            else{  $query->where('status', '!=', 1); }
        }
        if ($request->title  != '') {
            $query = $query->orWhereTranslationLike('title', '%' . request()->input('title') . '%');
        }
   
        if($request->tag_id != ''){
            $query = $query->where('tag_id',  request()->input('tag_id') );
        }

        $items = $query->paginate($this->pagination_count);
        return view('admin.dashboard.cms.portfolio.index', compact('items', 'tags'));
    }

    public function create()
    {
        $tags = $this->tags;
        return view('admin.dashboard.cms.portfolio.create', compact('tags'));
    }


    public function store(PortfolioRequest $request)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('portfolio'));
        }
        Portfolios::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.portfolio.index');
    }


    public function show(Portfolios $portfolio)
    {
        return view('admin.dashboard.cms.portfolio.show', compact('portfolio'));
    }


    public function edit(Portfolios $portfolio)
    {
        $tags = $this->tags;
        return view('admin.dashboard.cms.portfolio.edit', compact('portfolio', 'tags'));
    }


    public function update(PortfolioRequest $request, Portfolios $portfolio)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $this->delete_file($portfolio->image);
            $data['image'] = $this->upload_file($request->file('image'), ('portfolio'));
        }
        $portfolio->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if(request()->submit == "update"){ return  redirect()->back();}
        return redirect()->route('admin.portfolio.index');   
    }


    public function destroy(Portfolios $portfolio)
    {
        $this->delete_file($portfolio->image);
        $portfolio->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    public function update_status($id)
    {
        $portfolio = Portfolios::findOrfail($id);
        $portfolio->status == 1 ? $portfolio->status = 0 : $portfolio->status = 1;
        $portfolio->save();
        return redirect()->back();
    }

    public function update_featured($id)
    {
        $portfolio = Portfolios::findOrfail($id);
        $portfolio->feature == 1 ? $portfolio->feature = 0 : $portfolio->feature = 1;
        $portfolio->save();
        return redirect()->back();
    }



    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $portfolios = Portfolios::findMany($request['record']);
            foreach ($portfolios as $portfolio) {
                $portfolio->update(['status' => 1]);
            }
            session()->flash('success', trans('portfolio.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $portfolios = Portfolios::findMany($request['record']);
            foreach ($portfolios as $portfolio) {
                $portfolio->update(['status' => 0]);
            }
            session()->flash('success', trans('portfolio.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $portfolios = Portfolios::findMany($request['record']);
            foreach ($portfolios as $portfolio) {
                $this->delete_file($portfolio->image);
                $portfolio->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
