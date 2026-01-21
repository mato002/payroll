<?php

namespace App\Tenancy\Scopes;

use App\Tenancy\CurrentCompany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class CompanyScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Skip scoping in console (artisan commands, migrations, queues, etc.)
        if (app()->runningInConsole()) {
            return;
        }

        /** @var \App\Tenancy\CurrentCompany $currentCompany */
        $currentCompany = app(CurrentCompany::class);
        $companyId = $currentCompany->id();

        // If no company is set, prevent data leaks unless super admin bypass is enabled
        if (! $companyId) {
            if (config('tenancy.super_admin_bypass', true) && Auth::check() && Auth::user()->is_super_admin) {
                // Super admin can see all companies when no company context is set
                return;
            }

            // Prevent accidental data leaks - return empty result set
            $builder->whereRaw('1 = 0');
            return;
        }

        // Apply company scope
        $builder->where($model->getTable() . '.company_id', $companyId);
    }

    /**
     * Extend the query builder with the needed functions.
     */
    public function extend(Builder $builder): void
    {
        // Add method to bypass scope (use with caution!)
        $builder->macro('withoutCompanyScope', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });

        // Add method to scope to a specific company
        $builder->macro('forCompany', function (Builder $builder, $companyId) {
            return $builder->withoutGlobalScope($this)
                ->where($builder->getModel()->getTable() . '.company_id', $companyId);
        });
    }
}

