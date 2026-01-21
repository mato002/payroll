<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;

class EmployeePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'company_admin', 'payroll_officer'], true);
    }

    public function view(User $user, Employee $employee): bool
    {
        if ($user->role === 'super_admin') {
            return true;
        }

        if ($user->role === 'employee' && $employee->user_id === $user->id) {
            return true;
        }

        return in_array($user->role, ['company_admin', 'payroll_officer'], true)
            && $user->company_id === $employee->company_id;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'company_admin', 'payroll_officer'], true);
    }

    public function update(User $user, Employee $employee): bool
    {
        if ($user->role === 'super_admin') {
            return true;
        }

        return in_array($user->role, ['company_admin', 'payroll_officer'], true)
            && $user->company_id === $employee->company_id;
    }

    public function delete(User $user, Employee $employee): bool
    {
        return $this->update($user, $employee);
    }
}

