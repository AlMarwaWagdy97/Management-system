<?php

namespace App\Http\Requests\Admin\CMS;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionsRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules() {
        return $this->isMethod('POST') ? [
            'name' => ['string' , 'required' , Rule::unique('permissions' , 'name')],
        ] : [
            'name' => ['string' , 'required' , Rule::unique('permissions' , 'name')->ignore(request('permission_id'))],
        ];
    }

    public function getSanitized(){
        return $this->validated();
    }
}
