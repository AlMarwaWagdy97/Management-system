<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CharityProject;

class CharityProjectController extends Controller
{

    /**
     * Display the specified resource.
     */
public function show(Request $request, string $id)
{
    $amount = request('amount');

    if (is_numeric($id)) {
        $project = CharityProject::with(['trans', 'categories', 'categories.trans'])->findOrFail($id);
    } else {
        $project = CharityProject::with(['trans', 'categories', 'categories.trans'])
            ->whereHas('trans', function ($q) use ($id) {
                $q->where('slug', $id);
            })
            ->first();

        if ($project == null) {
            abort(404);
        }
    }

    return view('site.pages.charity-project.show', compact('project', 'amount'));
}





}
