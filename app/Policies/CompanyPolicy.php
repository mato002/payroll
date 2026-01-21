<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'super_admin';
    }

    public function view(User $user, Company $company): bool
    {
        if ($user->role === 'super_admin') {
            return true;
        }

        return $user->company_id === $company->id
            && in_array($user->role, ['company_admin', 'payroll_officer'], true);
    }

    public function create(User $user): bool
    {
        return $user->role === 'super_admin';
    }

    public function update(User $user, Company $company): bool
    {
        return $user->role === 'super_admin';
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->role === 'super_admin';
    }
}

