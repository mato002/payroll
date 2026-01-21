<?php

if (! function_exists('currentCompany')) {
    /**
     * Get the current company instance.
     */
    function currentCompany(): ?\App\Models\Company
    {
        return app(\App\Tenancy\CurrentCompany::class)->get();
    }
}

if (! function_exists('currentCompanyId')) {
    /**
     * Get the current company ID.
     */
    function currentCompanyId(): ?int
    {
        return app(\App\Tenancy\CurrentCompany::class)->id();
    }
}

if (! function_exists('hasCompany')) {
    /**
     * Check if a company is currently set.
     */
    function hasCompany(): bool
    {
        return app(\App\Tenancy\CurrentCompany::class)->has();
    }
}

if (! function_exists('setCompany')) {
    /**
     * Set the current company.
     */
    function setCompany(\App\Models\Company $company): void
    {
        app(\App\Tenancy\CurrentCompany::class)->set($company);
    }
}
