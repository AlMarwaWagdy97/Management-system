<?php

namespace App\Http\Requests\Admin\CMS;

use Locale;
use App\Models\Categories;
use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $req = [];
        
        foreach (config('translatable.locales') as $locale) {
            $req += [$locale . '.title' => 'required'];
            $req += [$locale . '.slug' => 'required'];
            $req += [$locale . '.description' => 'nullable'];
            $req += [$locale . '.content' => 'nullable'];
            $req += [$locale . '.meta_title' => 'nullable'];
            $req += [$locale . '.meta_description' => 'nullable'];
            $req += [$locale . '.meta_key' => 'nullable'];
        }


        $req += [
            'status' => 'nullable',
            'image' => 'nullable|' . ImageValidate(),
            'sort' => 'nullable',
            'feature' => 'nullable',
            'parent_id' => 'nullable',
            'updated_by' => 'nullable',
            'created_by' => 'nullable'
        ];

        return $req;
    }

    public function getSanitized()
    {
        $data = $this->validated();

        $data['status'] = isset($data['status']) ? true : false;
        $data['feature'] = isset($data['feature']) ? true : false;
        $data['level'] = updateLevel(@Categories::find($data['parent_id']));
        
        foreach (config('translatable.locales') as $locale) {
            if (isset($data[$locale]['slug'])) {
                $data[$locale]['slug'] = slug($data[$locale]['slug']);
            }
        }
        
        if (request()->isMethod('PUT')) {
            $data['updated_by'] = @auth()->user()->id;
        } else {
            $data['created_by'] = @auth()->user()->id;
        }
        
        return $data;
    }
}