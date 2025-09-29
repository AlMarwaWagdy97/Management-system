<?php

namespace App\Http\Requests\Admin\CMS;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Locale;

class PaymentMethodRequset extends FormRequest
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
        $req = [];
        foreach (config('translatable.locales') as $locale) {
            $req += [$locale . '.title' => 'required'];
            $req += [$locale . '.content' => 'nullable'];
        }
        $req += ['image' => 'nullable|' . ImageValidate()];
        $req += ['min_price' => 'nullable'];
        $req += ['payment_key' => 'nullable'];
        $req += ['meta' => 'nullable'];

        $req += ['cart_show' => 'nullable'];
        $req += ['status' => 'nullable'];
        $req += ['updated_by' => 'nullable'];
        $req += ['created_by' => 'nullable'];
        $req += ['banksList' => 'nullable'];
        $req += ['name_holder' => 'nullable'];
        $this->isMethod('PUT') ? $req += ['old' => 'nullable'] : '';
        return $req;
    }


    public function getSanitized()
    {
        $data = $this->validated();
        $data['status'] = isset($data['status']) ? true : false;
        $data['cart_show'] = isset($data['cart_show']) ? true : false;

        if (request()->isMethod('PUT')) {
            $data['updated_by'] = @Auth::user()->id;
        } else {
            $data['created_by'] = @Auth::user()->id;
        }
        return $data;
    }
}
