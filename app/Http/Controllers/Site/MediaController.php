<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * show the all media.
     */
    public function index(Request $request)
    {
        $items =  Articles::with('trans')->active()->orderBy('sort', 'ASC')->limit(@request()->key ??8)->get();

        return view('site.pages.media.index', compact('items'));
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        if (is_numeric($id)) {
            $item = Articles::active()->findOrFail($id);
        } else {
            $item = Articles::active()->with('trans')->whereHas('trans', function ($q) use ($id) {
                $q->where('slug', $id);
            })->first();
            if ($item == null) abort('404');
        }
        return view('site.pages.media.show', compact('item'));
    }
}
