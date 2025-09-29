<?php

namespace App\Http\Requests\Site\Profile;

use Illuminate\Foundation\Http\FormRequest;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardExpirationMonth;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardNumber;

class CreditCardsRequest extends FormRequest
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
            'number'        => 'required|min:16|max:16',
            'expired_month' => 'required|string|min:2|max:2',
            'expired_year'  => 'required|string|min:2|max:2',
            'cvv'           => 'required|string|min:3|max:3',
            'name'           => 'required|string|min:3',
            
        ];
    }
}
