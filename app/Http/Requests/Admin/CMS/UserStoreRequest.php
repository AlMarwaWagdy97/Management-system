<?php

namespace App\Http\Requests\Admin\CMS;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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

        return $this->isMethod('POST')? [
            'user_name' => ['required','string'],
            'email'=>['required' , 'email' ,Rule::unique('accounts' , 'email')],
            'mobile' =>['required','min:9',Rule::unique('accounts' , 'mobile')],
            'status' => ['nullable'],
            'password'=> ['required' , 'string' , 'min:8' , 'max:250','confirmed'],
            'password_confirmation' => ['required','same:password'],
            'roles'=> ['required','array'],
        ] : [
            'user_name' => ['required','string'],
            'email'=>['required' , 'email' ,Rule::unique('accounts' , 'email')->ignore($this->get('id'))],
            'mobile' =>['required','min:9',Rule::unique('accounts' , 'mobile')->ignore($this->get('id'))],
            'status' => ['nullable'],
            'password'=>['nullable' , 'string' , 'min:8' , 'max:250','confirmed'],
            'password_confirmation' => ['nullable','same:password'],
            'roles'=> ['required','array'],
        ];

    }


    public function getSanitized(){
        $data = $this->validated();
        $data['status'] = isset($data['status']) ? true : false;
        $data['type'] = ['admin'];
        // $data['password'] = Hash::make($data['password']);

        return $data;
    }
}
