<?php

namespace App\Http\Controllers\Onboarding;

use App\Http\Controllers\Controller;
use App\Http\Requests\Onboarding\UpdateCompanyProfileRequest;
use App\Models\Company;
use App\Tenancy\CurrentCompany;
use Illuminate\Support\Facades\Storage;

class CompanyProfileController extends Controller
{
    /**
     * Show the company profile onboarding form.
     */
    public function edit()
    {
        /** @var \App\Tenancy\CurrentCompany $currentCompany */
        $currentCompany = app(CurrentCompany::class);
        $company = $currentCompany->get();

        if (! $company) {
            abort(404, 'Company not found.');
        }

        return view('onboarding.company-profile', [
            'company' => $company,
        ]);
    }

    /**
     * Update company profile details during onboarding.
     */
    public function update(UpdateCompanyProfileRequest $request)
    {
        /** @var \App\Tenancy\CurrentCompany $currentCompany */
        $currentCompany = app(CurrentCompany::class);
        $company = $currentCompany->get();

        if (! $company) {
            abort(404, 'Company not found.');
        }

        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('company-logos', 'public');

            if ($company->logo_path) {
                Storage::disk('public')->delete($company->logo_path);
            }

            $data['logo_path'] = $path;
        }

        $company->update([
            'legal_name'   => $data['legal_name'] ?? $company->legal_name,
            'tax_id'       => $data['tax_id'] ?? $company->tax_id,
            'currency'     => $data['currency'] ?? $company->currency,
            'billing_email'=> $data['billing_email'] ?? $company->billing_email,
            'address_line1'=> $data['address_line1'] ?? $company->address_line1,
            'address_line2'=> $data['address_line2'] ?? $company->address_line2,
            'city'         => $data['city'] ?? $company->city,
            'state'        => $data['state'] ?? $company->state,
            'postal_code'  => $data['postal_code'] ?? $company->postal_code,
            'country'      => $data['country'] ?? $company->country,
        ] + (isset($data['logo_path']) ? ['logo_path' => $data['logo_path']] : []));

        return redirect()
            ->route('company.admin.dashboard')
            ->with('status', 'Company profile updated successfully.');
    }
}

