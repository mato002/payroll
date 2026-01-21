<?php

namespace App\Http\Requests\Onboarding;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyProfileRequest extends FormRequest
{
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
            'legal_name'    => ['nullable', 'string', 'max:255'],
            'tax_id'        => ['nullable', 'string', 'max:100'],
            'currency'      => ['nullable', 'string', 'size:3'],
            'billing_email' => ['nullable', 'email', 'max:255'],
            'address_line1' => ['nullable', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city'          => ['nullable', 'string', 'max:100'],
            'state'         => ['nullable', 'string', 'max:100'],
            'postal_code'   => ['nullable', 'string', 'max:20'],
            'country'       => ['nullable', 'string', 'size:2'],
            'logo'          => ['nullable', 'image', 'max:2048'],
        ];
    }
}

