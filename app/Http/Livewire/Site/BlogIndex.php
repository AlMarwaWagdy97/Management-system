<?php

namespace App\Http\Livewire\Site;

use App\Models\Tag;
use Livewire\Component;
use App\Models\Articles;
use App\Models\ArticleTags;
use App\Models\Categories;
use App\Models\SettingsValues;
use Livewire\WithPagination;

class BlogIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $items,$recent_posts,$categories,$tags = [];
    public $sortByCreated_at = 'created_at';
    public $sortBySort = 'sort';

    public $sortDesc = 'DESC';
    public $sortAsc = 'ASC';

    public $slug_categories =[];
    public $slug_tag = [];

    public $paginateCount = 6;

    public function mount(){
        $settingsSite = @SettingsValues::query()->whereHas('setting',function($q){
            $q->where('key', 'general');
        })->get();
        $this->paginateCount = @$settingsSite->where('key', 'blogs_paginate')->first()->value;
    }
    

    public function categorySlug($slug){
        $this->slug_categories = $slug;
        $this->slug_tag = "";
    }

    public function tagSlug($slug){
        $this->slug_tag = $slug;
    }



    public function render()
    {
        $query = Articles::query()->with('trans')->active()->feature();
        $this->categories = Categories::query()->with('trans', 'articles')->active()->feature()->orderBy($this->sortBySort, $this->sortAsc);
      
        
        $this->recent_posts =  (clone $query)->orderBy($this->sortByCreated_at, $this->sortDesc)->with('trans')->limit(3)->get();
        $this->items = $query;


        if($this->slug_categories != null){
            $slug_category = (clone $this->categories)->whereTranslation('slug',$this->slug_categories)->get()->pluck('id');
            $this->items = $query->where('category_id', $slug_category);

        }

        if($this->slug_tag != null){
            $this->items= $query->whereHas('tags', function($q) {
                $q->whereTranslation('slug',$this->slug_tag);
            });
        }

        // filter Tags  ----------------------------------
        $req = ArticleTags::query()->whereIn('article_id', $query->pluck('id'))->get();
        $this->tags = Tag::query()->with('trans')->active()->feature()->orderBy($this->sortBySort, $this->sortAsc)->whereIn('id', $req->pluck('tag_id'))->get();
        // End filter Tags  -------------------------------


        $this->items =  $this->items->orderBy($this->sortBySort, $this->sortAsc)->paginate($this->paginateCount);
        $this->categories =  $this->categories->get();
        $links = $this->items;
        $this->items = collect($this->items->items()); 
        $items = $this->items;
        return view('livewire.site.blog-index', compact('links', 'items'));
    }
}                   

