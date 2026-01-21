<?php

namespace App\Policies;

use App\Models\PayrollRun;
use App\Models\User;

class PayrollRunPolicy
{
    /**
     * Determine if the user can view the payroll run.
     */
    public function view(User $user, PayrollRun $run): bool
    {
        // Must belong to the same company
        if ($user->companies()->where('companies.id', $run->company_id)->doesntExist()) {
            return false;
        }

        // Company admins and payroll managers can view
        return $this->hasPayrollAccess($user, $run->company_id);
    }

    /**
     * Determine if the user can create payroll runs.
     */
    public function create(User $user, ?int $companyId = null): bool
    {
        if ($companyId) {
            return $this->hasPayrollAccess($user, $companyId);
        }

        return $user->companies()->exists();
    }

    /**
     * Determine if the user can update the payroll run.
     */
    public function update(User $user, PayrollRun $run): bool
    {
        // Must belong to the same company
        if ($user->companies()->where('companies.id', $run->company_id)->doesntExist()) {
            return false;
        }

        // Only company admins can update
        return $this->hasPayrollAccess($user, $run->company_id) && $this->isCompanyAdmin($user, $run->company_id);
    }

    /**
     * Determine if the user can submit the payroll run for review.
     */
    public function submitForReview(User $user, PayrollRun $run): bool
    {
        if ($user->companies()->where('companies.id', $run->company_id)->doesntExist()) {
            return false;
        }

        // Company admins and payroll managers can submit for review if run is draft
        return $this->hasPayrollAccess($user, $run->company_id) && $run->isDraft();
    }

    /**
     * Determine if the user can approve/lock the payroll run.
     */
    public function approve(User $user, PayrollRun $run): bool
    {
        // Must belong to the same company
        if ($user->companies()->where('companies.id', $run->company_id)->doesntExist()) {
            return false;
        }

        // Only company admins can approve, and only when run is under review
        return $this->isCompanyAdmin($user, $run->company_id) && $run->canApprove();
    }

    /**
     * Determine if the user can delete the payroll run.
     */
    public function delete(User $user, PayrollRun $run): bool
    {
        // Must belong to the same company
        if ($user->companies()->where('companies.id', $run->company_id)->doesntExist()) {
            return false;
        }

        // Only company admins can delete, and only if not locked
        return $this->isCompanyAdmin($user, $run->company_id) && $run->status !== 'closed';
    }

    /**
     * Check if user has payroll access (admin or payroll manager role).
     */
    protected function hasPayrollAccess(User $user, int $companyId): bool
    {
        return $this->isCompanyAdmin($user, $companyId)
            || $user->hasRoleInCompany('payroll_manager', $companyId);
    }

    /**
     * Check if user is company admin.
     */
    protected function isCompanyAdmin(User $user, int $companyId): bool
    {
        return $user->hasRoleInCompany('company_admin', $companyId)
            || $user->companies()->where('companies.id', $companyId)->wherePivot('is_owner', true)->exists();
    }
}
