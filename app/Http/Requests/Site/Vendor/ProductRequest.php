<?php

namespace App\Http\Requests\Site\Vendor;

use App\Enums\ProductStatusEnum;
use Illuminate\Foundation\Http\FormRequest;


class ProductRequest extends FormRequest
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
        $req = [];
        foreach (config('translatable.locales') as $locale) {
            $req += [$locale . '.title' => 'required|string|min:3'];
            $req += [$locale . '.slug' => 'nullable|string|min:3'];
            $req += [$locale . '.description' => 'nullable|string|min:3'];
        }

        $req += ['image' => 'nullable'];
        $req += ['cover_image' => 'nullable'];

        $req += ['vendor_price'            => 'required'];
        $req += ['sort'             => 'nullable'];
        $req += ['category_id'      => 'nullable'];
        return $req;
    }
    public function getSanitized(){
        $data = $this->validated();

        foreach (config('translatable.locales') as $locale) {
            if(@$data[$locale]['slug'] != null) continue;
            $data[$locale]['slug'] = slug($data[$locale]['title']);
        }
        $data['vendor_id'] =  @auth('account')->user()->vendor?->id;
        $data['feature'] = false;
        $data['status'] = ProductStatusEnum::PENDING;

        if (request()->isMethod('PUT')){ $data['updated_by']  = @auth()->user()->id; }
        else{ $data['created_by']  = @auth()->user()->id; }
        return $data;
    }
}
