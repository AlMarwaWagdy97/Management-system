<?php

namespace App\Http\Requests\Admin\CMS;

use Locale;
use Illuminate\Foundation\Http\FormRequest;

class ArticlesRequest extends FormRequest
{

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
            $req += [$locale . '.description' => 'nullable'];
            $req += [$locale . '.content' => 'nullable'];

            $req += [$locale . '.meta_title' => 'nullable'];
            $req += [$locale . '.meta_description' => 'nullable'];
            $req += [$locale . '.meta_key' => 'nullable'];
        }
        $req += ['image' =>'nullable|' . ImageValidate()];
        $req += ['category_id' =>'nullable'];
        $req += ['tags' =>'nullable'];
        $req += ['status' =>'nullable'];
        $req += ['sort' =>'nullable'];
        $req += ['feature' =>'nullable'];
        return $req;
    }

    
    public function getSanitized(){
        $data = $this->validated();
        $data['status'] = isset($data['status']) ? true : false;
        $data['feature'] = isset($data['feature']) ? true : false;
        foreach(config('translatable.locales') as $locale){
            $data[$locale]['slug'] = slug($data[$locale]['slug']);
        }
        if (request()->isMethod('PUT')){  $data['updated_by']  = @auth()->user()->id;  }
        else{  $data['created_by']  = @auth()->user()->id;   }
        return $data;
    }

 
}
