<?php

namespace App\Http\Requests\Auth;

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
            'company_name' => ['required', 'string', 'max:255'],
            'admin_name'   => ['required', 'string', 'max:255'],
            'admin_email'  => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],

            'country'      => ['nullable', 'string', 'size:2'],
            'currency'     => ['nullable', 'string', 'size:3'],
        ];
    }
}

