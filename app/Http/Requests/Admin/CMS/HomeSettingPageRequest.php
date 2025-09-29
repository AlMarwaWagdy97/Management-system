<?php

namespace App\Http\Requests\Admin\CMS;

use Locale;
use Illuminate\Foundation\Http\FormRequest;

class HomeSettingPageRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        $req = [];
        foreach(config('translatable.locales') as $locale){
            $req += [$locale . '.title' => 'nullable'];
            $req += [$locale . '.description' => 'nullable'];
        }
        $req += ['image' =>'nullable|' . ImageValidate()];
        $req += ['status' =>'nullable'];
        $req += ['url' =>'nullable'];
        // $req += ['title_section' =>'nullable'];
        $req += ['updated_by' =>'nullable'];
        $req += ['created_by' =>'nullable'];
        return $req;
    }

    
    public function getSanitized(){

        $data = $this->validated();
        
        $data['status'] = isset($data['status']) ? true : false;

        if (request()->isMethod('PUT')){
            $data['updated_by']  = @auth()->user()->id;
        }
        else{
            $data['created_by']  = @auth()->user()->id;
        }
        return $data;
    }
}

