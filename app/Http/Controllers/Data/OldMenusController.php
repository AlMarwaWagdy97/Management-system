<?php

namespace App\Http\Controllers\Data;

use App\Models\Menue;
use Illuminate\Http\Request;
use App\Models\Data\DataMenus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Stichoza\GoogleTranslate\GoogleTranslate;

class OldMenusController extends Controller
{
    public function menus(){
        DB::beginTransaction();
        try{

            $menus = DataMenus::get();

            foreach($menus as $menu){
                $data = [
                    "ar" => [
                        'title' => $menu->name,
                        'slug' => $menu->alias,
                    ],
                    // "en" => [
                    //     'title' => GoogleTranslate::trans($menu->name, "en"),
                    //     'slug' => GoogleTranslate::trans($menu->alias, "en"),
                    // ],
                    "url" => $menu->url,
                    "type" => $menu->type,
                    "level" => $menu->level,
                    "sort" => $menu->arrangement,
                    "parent_id" => $menu->parent_id == 0 ? NULL : (@$menu->parent_id - 1),
                    "position" => "main",
                    "status" => $menu->status,
                ];
                $new_menu = Menue::create($data);
                // dd($new_menu);
            }
            DB::commit();

        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
       return "All Menu is updated";
    }

    public function menusUpdate(){
        DB::beginTransaction();
        try{
            $menus = Menue::get();
            foreach($menus as $menu){
                $menu->url = str_replace("https://birrukum.org", "", $menu->url);
                $menu->url = str_replace("http://birrukum.org", "", $menu->url);
                $menu->url = str_replace("/show/", "/", $menu->url);
                $menu->save();
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        return "All Menu is updated";
    }





    public function menusUpdateUrl(){
        DB::beginTransaction();
        try{
            $menus = Menue::get();
            foreach($menus as $menu){
                if($menu->type == "dynamic"){
                    $menu->dynamic_url = $menu->url;
                    $menu->save();
                }

            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        return "All Menu is updated";
    }
}
