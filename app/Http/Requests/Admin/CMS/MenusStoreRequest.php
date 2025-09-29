<?php

namespace App\Http\Requests\Admin\CMS;
use Locale;
use App\Enums\MunesEnum;
use App\Models\Menue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Menus;

class MenusStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $req = [];
        foreach(config('translatable.locales') as $locale){
            $req += [$locale . '.title' => 'required'];
            $req += [$locale . '.slug' => 'required'];
        }
        $req += ['parent_id' =>'nullable'];
        $req += ['type' =>'required'];
        $req += ['url' =>'nullable'];
        $req += ['url_dynamic' =>'nullable'];
        $req += ['level' =>'nullable'];
        $req += ['status' =>'nullable'];
        $req += ['updated_by' =>'nullable'];
        $req += ['created_by' =>'nullable'];

        
        return $req;

    }

    public function getSanitized(){
        $data = $this->validated();

        if( $data['parent_id'] == 0 ){$date['parent_id']  = Null;}

        $data['status'] = isset($date['status']) ? true :false;
        $data['level'] =  updateLevel(@Menue::find($data['parent_id']));

        if( $data['type'] == MunesEnum::DYNAMIC){
            $data['url'] = $data['url_dynamic'];
        }
        if(request()->isMethod('PUT')){
            $data['updated_by']  = @Auth::user()->id;

        }else{
            $data['created_by']  = @Auth::user()->id;
        }
        return $data;
    }

}
