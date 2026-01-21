<?php

namespace App\Tenancy;

use App\Models\Company;

class CurrentCompany
{
    protected ?Company $company = null;

    /**
     * Set the current company.
     */
    public function set(Company $company): void
    {
        $this->company = $company;
    }

    /**
     * Get the current company instance.
     */
    public function get(): ?Company
    {
        return $this->company;
    }

    /**
     * Get the current company ID.
     */
    public function id(): ?int
    {
        return $this->company?->id;
    }

    /**
     * Check if a company is currently set.
     */
    public function has(): bool
    {
        return $this->company !== null;
    }

    /**
     * Clear the current company.
     */
    public function clear(): void
    {
        $this->company = null;
    }

    /**
     * Get the company name.
     */
    public function name(): ?string
    {
        return $this->company?->name;
    }

    /**
     * Get the company slug.
     */
    public function slug(): ?string
    {
        return $this->company?->slug;
    }
}

