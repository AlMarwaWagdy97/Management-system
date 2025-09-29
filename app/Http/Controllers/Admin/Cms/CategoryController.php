<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\CategoriesRequest;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        return view('livewire.admin.cms.categories.index');
    }

    public function create()
    {
        $query = Categories::query()->with('trans');
        $ids = arrang_records(clone $query);
        if ($ids) $categories = @$query->whereIn('id', $ids)->orderByRaw("field(id," . implode(',', $ids) . ")")->get();
        else $categories = $query->get();

        return view('admin.dashboard.cms.categories.create', compact('categories'));
    }

    public function store(CategoriesRequest $request)
    {
        try {
            if ($request->hasFile('image')) {
                \Log::info('Store - Uploaded image info:', [
                    'mime_type' => $request->file('image')->getMimeType(),
                    'extension' => $request->file('image')->getClientOriginalExtension(),
                    'size' => $request->file('image')->getSize()
                ]);
            }

            $data = $request->getSanitized();

            if ($request->hasFile('image')) {
                $data['image'] = $this->upload_file($request->file('image'), 'categories');
            }

            Categories::create($data);
            session()->flash('success', trans('message.admin.created_sucessfully'));

            if (request()->submit == "new") {
                return redirect()->back();
            }
            return redirect()->route('admin.categories.index');
        } catch (\Exception $e) {
            \Log::error('Category store error:', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'حدث خطأ أثناء إنشاء الفئة. الرجاء المحاولة مرة أخرى.']);
        }
    }

    public function show(Categories $category)
    {
        $item = $category;
        return view('admin.dashboard.cms.categories.show', compact('item'));
    }

    public function edit(Categories $category)
    {
        $item = $category;
        $query = Categories::query()->with('trans');
        $childs = get_childs_id($item->children, $query);
        $ids = arrang_records(clone $query);
        if ($ids) $categories = $query->whereIn('id', $ids)->whereNotIn('id', $childs)->where('id', '!=', $item->id)->orderByRaw("field(id," . implode(',', $ids) . ")")->get();
        else $categories = $query->get();

        return view('admin.dashboard.cms.categories.edit', compact('item', 'categories'));
    }

    public function update(CategoriesRequest $request, Categories $category)
    {

        $data = $request->getSanitized();

         if ($request->hasFile('image')) {
            $this->delete_file($category->image);
            $data['image'] = $this->upload_file($request->file('image'), ('categories'));
        }

        $category->update($data);

        $items = Categories::query()->with('trans')->get();
        update_childs_level($category, $items);

        session()->flash('success', trans('message.admin.updated_sucessfully'));

        if (request()->submit == "update") {
            return redirect()->back();
        }

        return redirect()->route('admin.categories.index');
    }

    public function destroy(Categories $category)
    {
        $this->delete_file($category->image);
        $category->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }

    public function update_status($id)
    {
        $item = Categories::findOrfail($id);
        $item->status == 1 ? $item->status = 0 : $item->status = 1;
        $item->save();
        return redirect()->back();
    }

    public function update_featured($id)
    {
        $item = Categories::findOrfail($id);
        $item->feature == 1 ? $item->feature = 0 : $item->feature = 1;
        $item->save();
        return redirect()->back();
    }

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $items = Categories::findMany($request['record']);
            foreach ($items as $item) {
                $item->update(['status' => 1]);
            }
            session()->flash('success', trans('categories.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $items = Categories::findMany($request['record']);
            foreach ($items as $item) {
                $item->update(['status' => 0]);
            }
            session()->flash('success', trans('categories.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $items = Categories::findMany($request['record']);
            foreach ($items as $item) {
                $this->delete_file($item->image);
                $item->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }

    public function show_tree(Request $request)
    {
        $items = Categories::query()->with('trans')->get();
        $searchItem = [];
        if ($request->title) {
            $searchItem = Categories::query()->with('trans')->orWhereTranslationLike('title', '%' . $request->title . '%')->get();
        }
        return view('admin.dashboard.cms.categories.index', compact('items', 'searchItem'));
    }
}
