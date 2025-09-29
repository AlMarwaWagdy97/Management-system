<?php

namespace App\Http\Requests\Admin\CMS;

use Illuminate\Foundation\Http\FormRequest;
use Locale;

class PortfolioTagRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }




    public function rules() {
        $req = [];
        foreach(config('translatable.locales') as $locale){
            $req += [$locale . '.title' => 'required'];
        }
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
            $data[$locale]['slug'] = slug($data[$locale]['title']);
        }

        if (request()->isMethod('PUT')){ $data['updated_by']  = @auth()->user()->id;}
        else{$data['created_by']  = @auth()->user()->id;}

        return $data;
    }
}
