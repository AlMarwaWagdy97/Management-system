<?php

namespace App\Traits\Api\Request;

use App\Traits\Api\Response\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait RequestValidationErrorResponse
{
    use ResponseHandler;

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], 422)
        );
    }
}