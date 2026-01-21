<?php

namespace App\Policies;

use App\Models\Payslip;
use App\Models\User;

class PayslipPolicy
{
    /**
     * Determine if the user can view the payslip.
     */
    public function view(User $user, Payslip $payslip): bool
    {
        // Must belong to the same company
        if ($user->companies()->where('companies.id', $payslip->company_id)->doesntExist()) {
            return false;
        }

        // Employee can view their own payslip
        if ($user->employee && $user->employee->id === $payslip->employee_id) {
            return true;
        }

        // Company admins and payroll managers can view any payslip in their company
        return $this->hasPayrollAccess($user, $payslip->company_id);
    }

    /**
     * Determine if the user can download the payslip.
     */
    public function download(User $user, Payslip $payslip): bool
    {
        return $this->view($user, $payslip);
    }

    /**
     * Check if user has payroll access (admin or payroll manager role).
     */
    protected function hasPayrollAccess(User $user, int $companyId): bool
    {
        return $user->hasRoleInCompany('company_admin', $companyId)
            || $user->hasRoleInCompany('payroll_manager', $companyId)
            || $user->companies()->where('companies.id', $companyId)->wherePivot('is_owner', true)->exists();
    }
}
