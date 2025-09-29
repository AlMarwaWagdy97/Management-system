<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\Categories;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        // Fetch active blogs with translations and relations
        $blogs = Articles::with(['trans', 'categories', 'tags'])
            ->active()
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        // Fetch categories with translations and articles count
        $categories = Categories::with(['trans', 'articles'])
            ->active()
            ->orderBy('sort', 'asc')
            ->get();

        // Fetch recent posts
        $recentPosts = Articles::with('trans')
            ->active()
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('site.blogs.index', compact('blogs', 'categories', 'recentPosts'));
    }

    public function show($slug)
    {
        $blog = Articles::with(['trans', 'categories', 'tags'])
            ->whereHas('trans', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->active()
            ->firstOrFail();

        $relatedBlogs = collect();

        if ($blog->categories) {
            $relatedBlogs = Articles::with(['trans', 'categories'])
                ->where('id', '!=', $blog->id)
                ->whereHas('categories', function ($query) use ($blog) {
                    $query->where('id', $blog->categories->id);
                })
                ->active()
                ->limit(3)
                ->get();
        }

        $recentPosts = Articles::with('trans')
            ->active()
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        $categories = \App\Models\Categories::with(['trans'])
            ->active()
            ->orderBy('sort', 'asc')
            ->get();

        return view('site.blogs.show', compact('blog', 'relatedBlogs', 'recentPosts', 'categories'));
    }
}
