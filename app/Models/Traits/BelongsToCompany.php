<?php

namespace App\Models\Traits;

use App\Models\Company;
use App\Tenancy\CurrentCompany;
use App\Tenancy\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait BelongsToCompany
{
    /**
     * Boot the trait and apply global scope.
     */
    public static function bootBelongsToCompany(): void
    {
        static::addGlobalScope(new CompanyScope());

        // Auto-set company_id when creating
        static::creating(function (Model $model): void {
            /** @var \App\Tenancy\CurrentCompany $currentCompany */
            $currentCompany = app(CurrentCompany::class);

            if ($currentCompany->id() && empty($model->company_id)) {
                $model->company_id = $currentCompany->id();
            }
        });

        // Prevent changing company_id after creation (security)
        static::updating(function (Model $model): void {
            if ($model->isDirty('company_id') && $model->getOriginal('company_id')) {
                // Only allow super admin to change company_id
                if (! (Auth::check() && Auth::user()->is_super_admin)) {
                    throw new \Exception('Cannot change company_id after creation');
                }
            }
        });
    }

    /**
     * Initialize the trait.
     */
    public function initializeBelongsToCompany(): void
    {
        if (! isset($this->casts['company_id'])) {
            $this->casts['company_id'] = 'integer';
        }
    }

    /**
     * Get the company relationship.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Scope a query to a specific company.
     */
    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Check if the model belongs to the current company.
     */
    public function belongsToCurrentCompany(): bool
    {
        /** @var \App\Tenancy\CurrentCompany $currentCompany */
        $currentCompany = app(CurrentCompany::class);
        return $this->company_id === $currentCompany->id();
    }

    /**
     * Query without company scope (use with extreme caution!).
     */
    public static function withoutCompanyScope()
    {
        return static::withoutGlobalScope(CompanyScope::class);
    }
}

