<?php

namespace App\Http\Requests\Admin\CMS;

use Locale;
use Illuminate\Foundation\Http\FormRequest;

class StatuRequest extends FormRequest
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
        // return [
        //     'title' => 'required',
        //     'slug' => 'required',
        //     'description' => 'nullable',
        //    'status'=> 'nullable',
        //     'created_by'=> 'nullable',
        //     'updated_by'=> 'nullable',
        // ];

        $req = [];
        foreach(config('translatable.locales') as $locale){
            $req += [$locale . '.title' => 'required'];
            $req += [$locale . '.slug' => 'required'];
            $req += [$locale . '.description' => 'nullable'];
        }

        $req += ['color' =>'nullable'];
        $req += ['status' =>'nullable'];
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
