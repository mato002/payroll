<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        // Prefer the current company helper if available (path-based tenancy)
        $company = currentCompany();

        if (! $company instanceof Company) {
            /** @var \App\Models\User $user */
            $user = auth()->user();
            $company = $user?->companies()->where('is_active', true)->first();
        }

        abort_unless($company, 404, 'Company not found');

        return view('company.settings.index', [
            'company' => $company,
        ]);
    }

    public function update(Request $request)
    {
        /** @var Company|null $company */
        $company = currentCompany();

        if (! $company instanceof Company) {
            /** @var \App\Models\User $user */
            $user = auth()->user();
            $company = $user?->companies()->where('is_active', true)->first();
        }

        abort_unless($company, 404, 'Company not found');

        $data = $request->validate([
            'name'                => ['required', 'string', 'max:255'],
            'legal_name'          => ['nullable', 'string', 'max:255'],
            'registration_number' => ['nullable', 'string', 'max:255'],
            'tax_id'              => ['nullable', 'string', 'max:255'],
            'billing_email'       => ['nullable', 'email', 'max:255'],
            'country'             => ['nullable', 'string', 'size:2'],
            'timezone'            => ['nullable', 'string', 'max:191'],
            'currency'            => ['nullable', 'string', 'size:3'],
            'address_line1'       => ['nullable', 'string', 'max:255'],
            'address_line2'       => ['nullable', 'string', 'max:255'],
            'city'                => ['nullable', 'string', 'max:255'],
            'state'               => ['nullable', 'string', 'max:255'],
            'postal_code'         => ['nullable', 'string', 'max:50'],
        ]);

        // Normalize casing for some fields
        if (! empty($data['country'] ?? null)) {
            $data['country'] = strtoupper($data['country']);
        }
        if (! empty($data['currency'] ?? null)) {
            $data['currency'] = strtoupper($data['currency']);
        }

        $company->fill($data);
        $company->save();

        return redirect()
            ->route('companies.settings.index', ['company' => $company->slug])
            ->with('success', 'Settings updated successfully.');
    }
}
