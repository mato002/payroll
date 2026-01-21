<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanySignupRequest extends FormRequest
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
            // Company
            'company_name'          => ['required', 'string', 'max:255'],
            'legal_name'            => ['nullable', 'string', 'max:255'],
            'registration_number'   => ['nullable', 'string', 'max:100'],
            'tax_id'                => ['nullable', 'string', 'max:100'],
            'billing_email'         => ['required', 'email', 'max:255'],
            'country'               => ['nullable', 'string', 'size:2'],
            'timezone'              => ['nullable', 'string', 'max:64'],
            'currency'              => ['required', 'string', 'size:3'],
            'address_line1'         => ['nullable', 'string', 'max:255'],
            'address_line2'         => ['nullable', 'string', 'max:255'],
            'city'                  => ['nullable', 'string', 'max:100'],
            'state'                 => ['nullable', 'string', 'max:100'],
            'postal_code'           => ['nullable', 'string', 'max:20'],
            'logo'                  => ['nullable', 'image', 'max:2048'],

            // Admin user
            'admin_name'           => ['required', 'string', 'max:255'],
            'admin_email'          => ['required', 'email', 'max:255', 'unique:users,email'],
            'admin_password'       => ['required', 'string', 'min:8', 'confirmed'],

            // Plan
            'plan_code'            => ['required', 'string', 'exists:subscription_plans,code'],
        ];
    }
}

