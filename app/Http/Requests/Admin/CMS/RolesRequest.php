<?php

namespace App\Http\Requests\Admin\CMS;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RolesRequest extends FormRequest
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
        return $this->isMethod('POST') ? [
            'name' => ['string' , 'required' , Rule::unique('roles' , 'name')],
            'permissions' => ['array' , 'required'],
        ] : [
            'name' => ['string' , 'required' , Rule::unique('roles' , 'name')->ignore(request('role_id'))],
            'permissions' => ['array' , 'required'],
        ];
    }

    public function getSanitized(){
         $data =  $this->validated();
        $data['guard_name'] = "account";
        return $data;
    }
}
