<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'mobile'     => 'required|unique:donors|max:10|min:10',
            'full_name'  => 'required|max:190|min:3',
            'email'      => 'nullable|max:191',
            'identity'   => 'nullable',
            'device_id'  => 'nullable',
        ];
    }
}
