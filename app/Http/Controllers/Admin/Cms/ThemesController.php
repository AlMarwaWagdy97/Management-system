<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Themes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ThemesController extends Controller
{
    public function dashboardTheme(){
        return view('admin.dashboard.cms.themes.dashboard');  
    }  


    public function siteTheme(){
       
        return view('admin.dashboard.cms.themes.site');  
    }

    public function Themes_update(Request $request) {

        $data = $request->except(['_token']);
        foreach($data as $key => $item){
            $query = Themes::query()->where('key',$key)->get()->first();
            $values = [];
            foreach($item as $ind => $val){
                if($val != null && !is_string($val)){
                    if(@$query->value) $this->delete_file(json_decode(@$query->value)->$ind);
                    $values[$ind]= $this->upload_file($val, ('themes'), $ind);
                }
                else{
                    $values[$ind] = $val;
                }
            }
            $item =  $values;
            if($query  != null){
                $query->update(['value' => json_encode($item) ]);
            }
            else{
                Themes::create(['key' => $key, 'value' => json_encode($item) ]);
            }
        }

        session()->flash('success' , trans('message.admin.updated_sucessfully') );
        return redirect()->back();
    }


    public function Themes_reset(Request $request){
        $them = @Themes::query()->where('key', $request->key)->get()->first();
        if( $them != null ) $them->update(['value' => '']);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return back();
    }

}
