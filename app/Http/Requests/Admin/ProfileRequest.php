<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
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
            'name' => ['required','string'],
            'email'=>['required' , 'email' ,Rule::unique('users' , 'email')],
            'mobile' =>['required','min:10'],
            'image'  =>'nullable|' . ImageValidate(),
            'password'=>['required' , 'string' , 'min:8' , 'max:250','confirmed'],
            'password_confirmation' => ['required','same:password'],
        ] : [
            'name' => ['required','string'],
            'email'=>['required' , 'email' ,Rule::unique('users' , 'email')->ignore($this->get('id'))],
            'mobile' =>['required','min:10'],
            'image'  =>'nullable|' . ImageValidate(),
            'password'=>['nullable' , 'string' , 'min:8' , 'max:250','confirmed'],
            'password_confirmation' => ['nullable','same:password'],
        ];

    }

    
    public function getSanitized(){
        $data = $this->validated();
        return $data;
    }
}