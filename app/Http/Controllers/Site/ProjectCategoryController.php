<?php

namespace App\Http\Controllers\Site;

use App\Models\CharityProject;
use App\Models\CategoryProjects;
use App\Http\Controllers\Controller;

class ProjectCategoryController extends Controller
{

    /**
     * show all categories 
     */
    public function index()
    {   
        return view('site.pages.category.index'); 
    }


    /**
     * show spesific category by id 
     */
    public function show(string $id)
    {   
        if(is_numeric($id)){
            $category = CategoryProjects::findOrFail($id);
        }
        else{
            $category = CategoryProjects::with(['transNow'])->whereHas('trans', function ($q) use ($id){
                $q->where('slug', $id);
            })->first();
        }
        
        return view('site.pages.category.show', compact('category')); 
    }
}
