<?php

namespace App\Http\Requests\Admin\Domain;

use Illuminate\Foundation\Http\FormRequest;

class StoreDomainRequest extends FormRequest
{
    public function authorize(): bool
    {
        // TODO: Wire to your permission system, e.g., return $this->user()->can('domains.create');
        return true;
    }

    public function rules(): array
    {
        return [
            'domain_name' => ['required','string','max:255','unique:domains,domain_name'],
            'domain_url'  => ['required','url','max:255','unique:domains,domain_url'],
            'status'      => ['sometimes','boolean'],
            'token'       => ['nullable','string','max:255'],
            'type'        => ['required','in:zid,holol'],
        ];
    }

    public function attributes(): array
    {
        return [
            'domain_name' => 'اسم النطاق',
            'domain_url'  => 'رابط النطاق',
            'status'      => 'الحالة',
            'token'       => 'التوكن',
            'type'        => 'النوع',
        ];
    }
}
