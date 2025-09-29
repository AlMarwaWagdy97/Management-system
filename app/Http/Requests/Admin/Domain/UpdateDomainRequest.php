<?php

namespace App\Http\Requests\Admin\Domain;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDomainRequest extends FormRequest
{
    public function authorize(): bool
    {
        // TODO: Wire to your permission system, e.g., return $this->user()->can('domains.update');
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('domain')?->id ?? null;

        return [
            'domain_name' => ['required','string','max:255','unique:domains,domain_name,'. $id],
            'domain_url'  => ['required','url','max:255','unique:domains,domain_url,'. $id],
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
