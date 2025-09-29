<?php

namespace App\Http\Controllers\Site;

use App\Models\Articles;
use App\Models\Categories;
use App\Models\SettingsValues;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index()
    {
        // Get all categories (not just those with articles)
        $categories = Categories::query()
            ->with(['trans', 'articles' => function($q) {
                $q->active()->feature();
            }])
            ->active()
            ->feature()
            ->orderBy('sort', 'ASC')
            ->paginate(6);

        if (request()->ajax()) {
            $view = view('site.blog-categories.partials.categories', compact('categories'))->render();
            return response()->json(['html' => $view]);
        }

        return view('site.blog-categories.index', compact('categories'));
    }

    public function show($slug)
    {
        // Find category by slug
        $category = Categories::query()
            ->with('trans')
            ->active()
            ->feature()
            ->whereHas('trans', function($q) use ($slug) {
                $q->where('slug', $slug);
            })
            ->firstOrFail();
            
        // Get blog settings for pagination
        $settingsSite = SettingsValues::query()->whereHas('setting', function($q) {
            $q->where('key', 'general');
        })->get();
        
        $paginateCount = $settingsSite->where('key', 'blogs_paginate')->first()->value ?? 6;
        
        // Get blogs in this category
        $blogs = Articles::query()
            ->with(['trans', 'categories.trans', 'tags.trans'])
            ->active()
            ->feature()
            ->where('category_id', $category->id)
            ->orderBy('sort', 'ASC')
            ->get();
            
        // Get all categories for sidebar
        $allCategories = Categories::query()
            ->with('trans')
            ->active()
            ->feature()
            ->whereHas('articles', function($q) {
                $q->active()->feature();
            })
            ->orderBy('sort', 'ASC')
            ->get();
            
        // Get recent posts
        $recentPosts = Articles::query()
            ->with('trans')
            ->active()
            ->feature()
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        return view('site.blog-categories.show', compact('category', 'blogs', 'allCategories', 'recentPosts'));
    }
}
