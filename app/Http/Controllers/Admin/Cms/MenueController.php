<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Menue;
use App\Models\Pages;
use App\Models\Articles;
use App\Models\Services;
use App\Enums\UrlTypesEnum;
use Illuminate\Http\Request;
use App\Enums\MenuPositionEnum;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Admin\CMS\MenuRequest;
use App\Models\Categories;
use App\Models\CategoryProjects;
use App\Models\CharityProject;

class MenueController extends Controller
{

    public function index()
    {
        return view('livewire.admin.cms.menus.index');
    }

    public function create()
    {
        return view('admin.dashboard.cms.menus.create');
    }

    public function getMenus(Request $request)
    {

        $query = Menue::query()->with('trans');
        $ids = arrang_records($query->get());

        if ($request->position == MenuPositionEnum::MAIN) {
            if ($ids) $menus = $query->whereIn('id', $ids)->main()->orderByRaw("field(id," . implode(',', $ids) . ")")->get();
            else $menus = $query->get();
        } elseif ($request->position == MenuPositionEnum::FOOTER) {
            if ($ids) $menus = $query->whereIn('id', $ids)->footer()->orderByRaw("field(id," . implode(',', $ids) . ")")->get();
            else $menus = $query->get();
        }

        foreach ($menus as $menu) {
            $menu->name = $menu->trans->where('locale', app()->getLocale())->first()->title;
        }
        return $menus;
    }

    public function createMenu($id)
    {
        $item_parent_id = $id;
        $createMode = true;
        $items =  collect(Menue::query()->main()->with('trans')->get());
        return view('admin.dashboard.cms.menus.index', compact('items', 'item_parent_id', 'createMode'));
    }


    public function store(MenuRequest $request)
    {
        $data = $request->getSanitized();
        Menue::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if (request()->submit == "new") {
            return  redirect()->back();
        }
        Cache::forget('menus');
        return redirect()->route('admin.menus.index');
    }

    public function show(Menue $menu)
    {
        return view('admin.dashboard.cms.menus.show', compact('menu'));
    }


    public function edit(Menue $menu)
    {
        $item = $menu;
        if ($menu->position == MenuPositionEnum::FOOTER) {
            $menus = Menue::query()->footer()->with('trans')->get();
        } else {
            $menus = Menue::query()->main()->with('trans')->get();
        }
        $childs =  get_childs_id($item->children,  $menus);
        $ids = arrang_records($menus);
        Cache::forget('menus');
        if ($ids) $menus = Menue::query()->with('trans')->whereIn('id', $ids)->whereNotIn('id', $childs)->where('id', '!=',  $item->id)->orderByRaw("field(id," . implode(',', $ids) . ")")->get();
        return view('admin.dashboard.cms.menus.edit', compact('menu', 'menus'));
    }

    public function update(MenuRequest $request, Menue $menu)
    {
        
        $data = $request->getSanitized();
        $menu->update($data);
        $query = Menue::query()->with('trans')->get();
        update_childs_level($menu,  $query);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        Cache::forget('menus');
        if (request()->submit == "update") {
            return  redirect()->back();
        }
        return redirect()->route('admin.menus.index');
    }


    public function destroy(Menue $menu)
    {
        Cache::forget('menus');
        $menu->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->route('admin.menus.index');
    }

    public function update_status($id)
    {
        Cache::forget('menus');
        $menu = Menue::findOrfail($id);
        $menu->status == 1 ? $menu->status = 0 : $menu->status = 1;
        $menu->save();
        return redirect()->back();
    }


    public function actions(Request $request)
    {
        Cache::forget('menus');

        if ($request['publish'] == 1) {
            $menus = Menue::findMany($request['record']);
            foreach ($menus as $menu) {
                $menu->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $menus = Menue::findMany($request['record']);
            foreach ($menus as $menu) {
                $menu->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $menus = Menue::findMany($request['record']);
            foreach ($menus as $menu) {

                $menu->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }


    public function show_tree(Request $request)
    {
        if ($request->position == MenuPositionEnum::FOOTER) {
            $items =  Menue::query()->footer()->with('trans')->get();
        } else {
            $items =  Menue::query()->main()->with('trans')->get();
        }
        $searchItem = [];
        if ($request->title) {
            if ($request->position == MenuPositionEnum::FOOTER) {
                $searchItem = Menue::query()->footer()->with('trans')->WhereTranslationLike('title', '%' . $request->title . '%')->get();
            } else {
                $searchItem = Menue::query()->main()->with('trans')->WhereTranslationLike('title', '%' . $request->title . '%')->get();
            }
        }
        return view('admin.dashboard.cms.menus.index', compact('items', 'searchItem'));
    }


    public function getUrl(Request $request)
    {
        $name = $request->name;
        $res = [];
        if ($name == UrlTypesEnum::PAGES) {
            $items = Pages::query()->with('trans')->active()->get(['id']);
            foreach ($items as $item) {
                $res[] =  '/pages/' . $item->trans->where("locale", app()->getLocale())->first()->slug;
            }
        }
        if ($name == UrlTypesEnum::CATEGORIES) {
            $items = CategoryProjects::query()->with('trans')->active(1)->get(['id']);
            foreach ($items as $item) {
                $res[] =  '/projectCategories/' . $item->trans->where("locale", app()->getLocale())->first()->slug;
            }
        }
        if ($name == UrlTypesEnum::PROJECTS) {
            $items = CharityProject::query()->with('trans')->status(1)->get(['id']);
            foreach ($items as $item) {
                $res[] =  '/projects/' . $item->trans->where("locale", app()->getLocale())->first()->slug;
            }
        }
        if ($name == UrlTypesEnum::BLOGS) {
            $items = Articles::with('trans')->active()->get(['id']);
            foreach ($items as $item) {
                $res[] =  '/blogs/' . $item->trans->where("locale", app()->getLocale())->first()->slug;
            }
        }
        if ($name == UrlTypesEnum::CategoryBLOGS) {
            $items = Categories::with('trans')->active()->get(['id']);
            foreach ($items as $item) {
                $res[] =  '/blog-categories/' . $item->trans->where("locale", app()->getLocale())->first()->slug;
            }
        }
        // elseif($name == UrlTypesEnum::CATEGORIES){
        //     $items = Categories::query()->with('trans')->active()->get(['id']);
        //     foreach($items as $item){
        //         $res[] = '/categories/' .  $item->trans->where("locale",app()->getLocale())->first()->slug;
        //     }
        // }
        // elseif ($name == UrlTypesEnum::ARTICLES) {
        //     $items = Articles::query()->with('trans')->active()->get(['id']);
        //     foreach ($items as $item) {
        //         $res[] = '/news/' . $item->trans->where("locale", app()->getLocale())->first()->slug;
        //     }
        // } elseif ($name == UrlTypesEnum::SERVICES) {
        //     $items = Services::query()->with('trans')->active()->get(['id']);
        //     foreach ($items as $item) {
        //         $res[] = '/services/' . $item->trans->where("locale", app()->getLocale())->first()->slug;
        //     }
        // }
        // elseif($name == UrlTypesEnum::NEWS){
        //     $items = News::query()->with('trans')->active()->get(['id']);
        //     foreach($items as $item){
        //         $res[] = '/offers/' .$item->trans->where("locale",app()->getLocale())->first()->slug;
        //     }
        // }
        return $res;
    }
}
