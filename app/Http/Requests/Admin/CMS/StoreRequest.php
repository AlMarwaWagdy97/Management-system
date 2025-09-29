<?php

namespace App\Http\Requests\Admin\CMS;

use Locale;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            $req += [$locale . '.slug' => 'required'];
            $req += [$locale . '.description' => 'nullable'];
            $req += [$locale . '.meta_title' => 'nullable'];
            $req += [$locale . '.meta_description' => 'nullable'];
            $req += [$locale . '.meta_key' => 'nullable'];
        }
        $req += ['employee_image' => 'nullable|' . ImageValidate()];
        $req += ['background_image' => 'nullable|' . ImageValidate()];

        $req += ['full_name' => 'required'];
        $req += $this->isMethod('POST') ? [
            ['email' => 'required' | 'email', Rule::unique('stores', 'email')],

        ] : [
            ['email' => 'required' | 'email', Rule::unique('stores', 'email')->ignore($this->get('id'))],

        ];

        $req += ['password' => 'required'];
        $req += ['mobile' => 'nullable'];
        $req += ['whatsapp' => 'nullable'];
        $req += ['employee_name' => 'nullable'];
        $req += ['employee_number' => 'nullable'];
        $req += ['department' => 'nullable'];
        $req += ['ax_store_number' => 'nullable'];
        $req += ['jop' => 'nullable'];
        $req += ['location' => 'nullable'];
        $req += ['backgeound_color' => 'nullable'];
        $req += ['status' => 'nullable'];
        return $req;
    }

    public function getSanitized()
    {
        $data = $this->validated();
        $data['status'] = isset($data['status']) ? true : false;
        foreach (config('translatable.locales') as $locale) {
            $data[$locale]['slug'] = slug($data[$locale]['slug']);
        }
        if (request()->isMethod('PUT')) {
            $data['updated_by']  = @auth()->user()->id;
        } else {
            $data['created_by']  = @auth()->user()->id;
        }
        return $data;
    }
}
