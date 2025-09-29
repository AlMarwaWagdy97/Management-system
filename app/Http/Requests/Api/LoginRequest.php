<?php

namespace App\Http\Requests\Api;

use App\Services\Api\CustomFormRequest;

class LoginRequest extends CustomFormRequest
{
   
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mobile'    => 'required|min:10|max:10',
            'device_id' => 'nullable',
        ];
    }
}
