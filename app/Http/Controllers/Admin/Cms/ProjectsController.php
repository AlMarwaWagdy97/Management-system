<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\CategoryProjects;
use App\Models\Data\ProjectCategoty;
use App\Models\Images;
use App\Models\Projects;
use App\Models\Portfolios;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\ProjectsRequest;

class ProjectsController extends Controller
{
    public $portfolio;

    public function __construct()
    {
        $this->portfolio = Portfolios::query()->with('trans')->get();
    }

    public function index(Request $request)
    {
        $query = Projects::query()->with('trans', 'portfolio')->orderBy('id', 'DESC');
        $portfolios = $this->portfolio;

        if($request->status  != ''){
            if( $request->status == 1) $query->where('status', $request->status );
            else{  $query->where('status', '!=', 1); }
        }
        if ($request->title  != '') {
            $query = $query->orWhereTranslationLike('title', '%' . request()->input('title') . '%');
        }
        if($request->portfolio_id != ''){
            $query = $query->where('portfolio_id',  request()->input('portfolio_id') );
        }

        $items = $query->paginate($this->pagination_count);
        return view('admin.dashboard.cms.projects.index', compact('items', 'portfolios'));
    }

    public function create()
    {
        $portfolios = $this->portfolio;
        return view('admin.dashboard.cms.projects.create', compact('portfolios'));
    }


    public function store(ProjectsRequest $request)
    {

        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('project'));
        }
        $project = Projects::create($data);
        if (@$data['gallery'] != null || @$data['gallery'] != []) {
            foreach($data['gallery'] as $key => $gallery){
                if($gallery != null){ $img = $this->upload_file( $gallery['img'] , ('project'));  }
                Images::create([
                'url' =>  $img,
                'sort' => 0, //$gallery['sort'],
                'image_type' => 'image',
                'parentable_id' => $project->id,
                'parentable_type' => Projects::class
                ]);
            }
        }
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.projects.index');
    }


    public function show(Projects $project)
    {
        return view('admin.dashboard.cms.projects.show', compact('project'));
    }


    public function edit(Projects $project)
    {
        $portfolios = $this->portfolio;
        return view('admin.dashboard.cms.projects.edit', compact('project', 'portfolios'));
    }


    public function update(ProjectsRequest $request, Projects $project)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $this->delete_file($project->background_image);
            $data['image'] = $this->upload_file($request->file('image'), ('project'));
        }
        $project->update($data);

        $this->updateImages($data, $project);

        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if(request()->submit == "update"){ return  redirect()->back();}
        return redirect()->route('admin.projects.index');
    }


    public function destroy(Projects $project)
    {
        $this->delete_file($project->image);
        $project->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    public function update_status($id)
    {
        $project = Projects::findOrfail($id);
        $project->status == 1 ? $project->status = 0 : $project->status = 1;
        $project->save();
        return redirect()->back();
    }

    public function update_featured($id)
    {
        $project = Projects::findOrfail($id);
        $project->feature == 1 ? $project->feature = 0 : $project->feature = 1;
        $project->save();
        return redirect()->back();
    }



    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $projects = Projects::findMany($request['record']);
            foreach ($projects as $project) {
                $project->update(['status' => 1]);
            }
            session()->flash('success', trans('project.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $projects = Projects::findMany($request['record']);
            foreach ($projects as $project) {
                $project->update(['status' => 0]);
            }
            session()->flash('success', trans('project.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $projects = Projects::findMany($request['record']);
            foreach ($projects as $project) {
                $this->delete_file($project->image);
                $project->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }

    public function updateImages($data, $project){
        // delete gallery ===============================================
        $oldGallery = $project->images;
        $updateGallery = @$data['old_image']['id'];
        $removeGallery = $oldGallery->whereNotIn('id',  $updateGallery);
        if(!empty($removeGallery)){
            foreach($removeGallery as $removeItem){
                $this->delete_file($removeItem->image);
                $removeItem->delete();
            }
        }
        if (@$data['gallery'] != null || @$data['gallery'] != []) {
            foreach($data['gallery'] as $key => $gallery){
                if($gallery != null){ $img = $this->upload_file( $gallery['img'] , ('project'));  }
                Images::create([
                'url' =>  $img,
                'sort' => 0, //$gallery['sort'],
                'image_type' => 'image',
                'parentable_id' => $project->id,
                'parentable_type' => Projects::class
                ]);
            }
        }
    }
}
