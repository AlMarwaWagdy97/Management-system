<?php

namespace App\Http\Requests\Admin\App;

use Illuminate\Foundation\Http\FormRequest;

class AppArticleRequest extends FormRequest
{
      /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $req = [];
        foreach(config('translatable.locales') as $locale){
            $req += [$locale . '.title' => 'required'];
            $req += [$locale . '.slug' => 'required'];
            $req += [$locale . '.description' => 'nullable'];
        }
        $req += ['image' =>'nullable|' . ImageValidate()];
        $req += ['section_id' =>'required'];
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