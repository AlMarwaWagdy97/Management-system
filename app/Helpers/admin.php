<?php


use App\Models\Themes;
use App\Enums\ProductStatusEnum;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

if (!function_exists('admin_path')) {
    function admin_path($path)
    {
        return asset("storage/admin/" . $path);
    }
}

if (!function_exists('getImage')) {
    function getImage($path = "empty.png")
    {
        return Storage::url($path ?? "empty.png");
    }
}

if (!function_exists('getImageThumb')) {
    function getImageThumb($path = "empty.png")
    {
        $path = $path ? str_replace("attachments", "attachments/thumbs/attachments", $path) : "empty.png";
        if(!str_contains($path, "attachments")){
            $path =  "attachments/" . $path;
        }
        return Storage::url($path);
    }
}

if (!function_exists('getImageThumbFileManger')) {
    function getImageThumbFileManger($path = "empty.png")
    {
        $path = $path ?  "attachments/thumbs/attachments/" . $path : "empty.png";
        return Storage::url($path);
    }
}
if (!function_exists('getImageFileManger')) {
    function getImageFileManger($path = "empty.png")
    {
        return asset(Storage::url('attachments/' . $path ?? "empty.png"));
    }
}


if (!function_exists('pagination_count')) {
    function pagination_count()
    {
        return 25;
    }
}

if (!function_exists('slug')) {
    function slug($value)
    {
        if (is_null($value)) {
            return "";
        }
        $value = trim($value, " ");
        $value = mb_strtolower($value, "UTF-8");;
        $value = preg_replace('/\s+/', ' ', $value);
        $value = str_replace(" ", '-', $value);
        return $value;
    }
}

if (!function_exists('removeHTML')) {
    function removeHTML($content)
    {
        $result = filter_var($content, FILTER_SANITIZE_STRING);
        $result = trim($result);
        $result = str_replace('&nbsp;', '', $result);
        return $result;
    }
}

if (!function_exists('ImageValidate')) {
    function ImageValidate($max = 2048, $pdf = false)
    {
        $validation_rule = "mimes:jpeg,png,jpg,gif,svg,bmp,webp";
        $validation_rule .= $pdf ?  ",pdf": "";
        $validation_rule .= '|max:' . ($max != null ? $max : "2048");
        return $validation_rule;
    }
}



if (!function_exists('updateLevel')) {
    function updateLevel($parent)
    {
        if ($parent == null) {
            return 1;
        } else {
            return $parent->level + 1;
        }
    }
}

if (!function_exists('getPathTree')) {
    function getPathTree($item)
    {
        $ids = [];
        getParent($item, $ids);
        return $ids;
    }
}

if (!function_exists('getParent')) {
    function getParent($child, &$ids)
    {
        if (@$child->parent_id != null) {
            $ids[] = $child->parent->id;
            return getParent(@$child->parent, $ids);
        }
    }
}

if (!function_exists('getAdminRoutes')) {
    function getAdminRoutes()
    {
        $routeCollection = Route::getRoutes();
        $routes = [];
        $permissions = [];
        foreach ($routeCollection as $value) {
            $routes[] =  $value->getName();
        }
        $routes = array_filter($routes);
        foreach ($routes as $route) {
            if (str_contains($route, "admin") == true) {
                $permissions[] = $route;
            }
        }
        return $permissions;
    }
}

if (!function_exists('syncPermisions')) {
    function syncPermisions($model = null)
    {
        $routes = getAdminRoutes();
        foreach ($routes as $route) {
            $permissionExist = (clone $model)->where('name', $route)->first();
            if ($permissionExist == null) { 
                Permission::create([
                    'name' => $route,
                    'guard_name' => 'account',
                ]);
            }
        }
    }
}


if (!function_exists('transPermission')) {
    function transPermission($val)
    {
        $cleanVal = str_replace('admin.', '', $val);
        $cleanVal = str_replace('.', '_', $cleanVal);
        $cleanVal = str_replace('-', '_', $cleanVal);
       return trans('permissions.permissions_list.' . $cleanVal);
    }
}

if (!function_exists('dashboard_themes')) {
    function dashboard_themes($key = null)
    {
        $theme = json_decode(@Themes::query()->where('key', 'dashboard')->get()->first()->value);
        return @$theme->$key;
    }
}

if (!function_exists('login_dashboard_themes')) {
    function login_dashboard_themes($key = false)
    {
        $theme = json_decode(@Themes::query()->where('key', 'login_dashboard')->get()->first()->value);
        return @$theme->$key;
    }
}

if (!function_exists('get_dashboard_themes')) {
    function get_dashboard_themes()
    {
        $theme = json_decode(@Themes::query()->where('key', 'dashboard')->get()->first()->value);
        return @$theme;
    }
}

if (!function_exists('get_login_dashboard_themes')) {
    function get_login_dashboard_themes()
    {
        $theme = json_decode(@Themes::query()->where('key', 'login_dashboard')->get()->first()->value);
        return @$theme;
    }
}

if (!function_exists('get_site_themes')) {
    function get_site_themes()
    {
        $theme = json_decode(@Themes::query()->where('key', 'site')->get()->first()->value);
        return @$theme;
    }
}



if (!function_exists('arrang_records')) {
    function arrang_records($items, $search_ids = [])
    {
        $ids = [];
        if ($search_ids != []) $parents = $items->whereIn('id', $search_ids);
        else $parents = $items->where('parent_id', null);
        foreach ($parents as $item) {
            $ids[] = $item->id;
            arrange_child($item, $ids, $items);
        }
        return $ids;
    }
}

if (!function_exists('arrange_child')) {
    function arrange_child($parent, &$ids, $items = null)
    {
        $children =  $items->where('parent_id', $parent->id);
        foreach ($children as $item) {
            $ids[] = $item->id;
            arrange_child($item, $ids, $items);
        }
    }
}


if (!function_exists('get_childs_id')) {
    function get_childs_id($items,  $tree)
    {
        $ids = [];
        foreach ($items as $item) {
            $ids[] = $item->id;
            arrange_child($item, $ids, $tree);
        }
        return $ids;
    }
}

if (!function_exists('update_childs_level')) {
    function update_childs_level($parent, $items = null)
    {
        $childsModel = [];
        get_childs($parent, $childsModel,  $items);
        if ($childsModel) {
            foreach ($childsModel as $childupdate) {
                if (isset($childupdate->level)) {
                    $childupdate->level =  updateLevel(@$childupdate->parent);
                    $childupdate->save();
                }
            }
        }

        return $childsModel;
    }
}

if (!function_exists('get_childs')) {
    function get_childs($parent, &$childsModel,  $items = null)
    {
        foreach ($parent->children as $item) {
            $childsModel[] = $item;
            arrange_child($item, $childsModel,  $items);
        }
    }
}

if (!function_exists('hinddelImage')) {
    function  hinddelImage($images)
    {
        if ($images != null) {
            $chr = str_replace('[', '', $images);
            $chr = str_replace(']', '', $chr);
            $chr = str_replace('"', '', $chr);

            $chr = explode(',', $chr);
            return $chr;
        } else return [];
    }
}

if (!function_exists('pathImage')) {
    function  pathImage($file)
    {
        return "storage/attachments/" . $file;
    }
}

if (!function_exists('ProjectType')) {
    function  ProjectType($data)
    {
        $projectType = [];
        if ($data['donation_type'] != null) {
            if ($data['donation_type'] == 'share') {
                foreach ($data['share_name'] as $key => $value) {
                    $projectType['data'][] = [
                        'name' => $value,
                        'value' => $data['share_value'][$key],
                    ];
                }
                $projectType  = ["type" => $data['donation_type']] + $projectType;
            } elseif ($data['donation_type'] == 'unit') {
                foreach ($data['donation_name'] as $key => $value) {
                    $projectType['data'][] = [
                        'name' => $value,
                        'value' => $data['donation_value'][$key],
                    ];
                }
                $projectType  = ["type" => $data['donation_type']] + $projectType;
            } elseif ($data['donation_type'] == 'fixed') {
                $projectType['data'] = $data['fixed_value'];
                $projectType  = ["type" => $data['donation_type']] + $projectType;
            } elseif ($data['donation_type'] == 'open') {
                $projectType['type'] = $data['donation_type'];
            }
            $projectType =  json_encode($projectType);
            return $projectType;
        }
    }
}

if (!function_exists('toHtml')) {
    function  toHtml($value)
    {
        switch ($value) {
            case ProductStatusEnum::PENDING:
                return '<span class="bg-warning status-label m-auto text-white rounded d-flex justify-content-center">' . trans('admin.' . ProductStatusEnum::PENDING) . ' </span>';
            case ProductStatusEnum::PUBLISHED:
                return '<span class="bg-success status-label m-auto text-white rounded d-flex justify-content-center">' .  trans('admin.' . ProductStatusEnum::PUBLISHED) . ' </span>';
            case ProductStatusEnum::UNPUBLISHED:
                return '<span class="bg-danger status-label m-auto text-white rounded d-flex justify-content-center px-1">' .  trans('admin.' . ProductStatusEnum::UNPUBLISHED)  . ' </span>';
            default:
                return '<span class="bg-warning status-label m-auto text-white rounded d-flex justify-content-center"> -- </span>';
        }
    }
}
