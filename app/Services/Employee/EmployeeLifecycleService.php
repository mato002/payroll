<?php

namespace App\Services\Employee;

use App\Models\Employee;
use App\Models\EmployeeLifecycleEvent;
use App\Models\SalaryChangeHistory;
use App\Models\TerminationSettlement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeLifecycleService
{
    /**
     * Record a new hire event.
     */
    public function recordHire(
        Employee $employee,
        ?string $description = null,
        ?Carbon $effectiveDate = null
    ): EmployeeLifecycleEvent {
        return DB::transaction(function () use ($employee, $description, $effectiveDate) {
            $event = EmployeeLifecycleEvent::create([
                'company_id' => $employee->company_id,
                'employee_id' => $employee->id,
                'created_by' => Auth::id(),
                'event_type' => 'hired',
                'title' => sprintf('Employee Hired: %s %s', $employee->first_name, $employee->last_name),
                'description' => $description ?? sprintf(
                    'Employee %s %s was hired on %s',
                    $employee->first_name,
                    $employee->last_name,
                    $employee->hire_date->format('Y-m-d')
                ),
                'effective_date' => $effectiveDate ?? $employee->hire_date,
                'event_data' => [
                    'job_title' => $employee->job_title,
                    'department_id' => $employee->department_id,
                    'employment_type' => $employee->employment_type,
                    'pay_frequency' => $employee->pay_frequency,
                ],
            ]);

            return $event;
        });
    }

    /**
     * Record a promotion event.
     */
    public function recordPromotion(
        Employee $employee,
        string $newJobTitle,
        ?int $newDepartmentId = null,
        ?string $description = null,
        ?Carbon $effectiveDate = null,
        ?int $relatedSalaryChangeId = null
    ): EmployeeLifecycleEvent {
        return DB::transaction(function () use (
            $employee,
            $newJobTitle,
            $newDepartmentId,
            $description,
            $effectiveDate,
            $relatedSalaryChangeId
        ) {
            $oldJobTitle = $employee->job_title;
            $oldDepartmentId = $employee->department_id;

            $event = EmployeeLifecycleEvent::create([
                'company_id' => $employee->company_id,
                'employee_id' => $employee->id,
                'created_by' => Auth::id(),
                'event_type' => 'promoted',
                'title' => sprintf('Promotion: %s → %s', $oldJobTitle ?? 'N/A', $newJobTitle),
                'description' => $description ?? sprintf(
                    'Employee promoted from %s to %s',
                    $oldJobTitle ?? 'N/A',
                    $newJobTitle
                ),
                'effective_date' => $effectiveDate ?? now(),
                'related_salary_change_id' => $relatedSalaryChangeId,
                'event_data' => [
                    'old_job_title' => $oldJobTitle,
                    'new_job_title' => $newJobTitle,
                    'old_department_id' => $oldDepartmentId,
                    'new_department_id' => $newDepartmentId,
                ],
            ]);

            // Update employee record
            $employee->update([
                'job_title' => $newJobTitle,
                'department_id' => $newDepartmentId ?? $employee->department_id,
            ]);

            return $event;
        });
    }

    /**
     * Record a demotion event.
     */
    public function recordDemotion(
        Employee $employee,
        string $newJobTitle,
        ?int $newDepartmentId = null,
        ?string $description = null,
        ?Carbon $effectiveDate = null,
        ?int $relatedSalaryChangeId = null
    ): EmployeeLifecycleEvent {
        return DB::transaction(function () use (
            $employee,
            $newJobTitle,
            $newDepartmentId,
            $description,
            $effectiveDate,
            $relatedSalaryChangeId
        ) {
            $oldJobTitle = $employee->job_title;
            $oldDepartmentId = $employee->department_id;

            $event = EmployeeLifecycleEvent::create([
                'company_id' => $employee->company_id,
                'employee_id' => $employee->id,
                'created_by' => Auth::id(),
                'event_type' => 'demoted',
                'title' => sprintf('Demotion: %s → %s', $oldJobTitle ?? 'N/A', $newJobTitle),
                'description' => $description ?? sprintf(
                    'Employee demoted from %s to %s',
                    $oldJobTitle ?? 'N/A',
                    $newJobTitle
                ),
                'effective_date' => $effectiveDate ?? now(),
                'related_salary_change_id' => $relatedSalaryChangeId,
                'event_data' => [
                    'old_job_title' => $oldJobTitle,
                    'new_job_title' => $newJobTitle,
                    'old_department_id' => $oldDepartmentId,
                    'new_department_id' => $newDepartmentId,
                ],
            ]);

            // Update employee record
            $employee->update([
                'job_title' => $newJobTitle,
                'department_id' => $newDepartmentId ?? $employee->department_id,
            ]);

            return $event;
        });
    }

    /**
     * Record a transfer event (department/position change without promotion/demotion).
     */
    public function recordTransfer(
        Employee $employee,
        ?int $newDepartmentId = null,
        ?string $newJobTitle = null,
        ?string $description = null,
        ?Carbon $effectiveDate = null
    ): EmployeeLifecycleEvent {
        return DB::transaction(function () use (
            $employee,
            $newDepartmentId,
            $newJobTitle,
            $description,
            $effectiveDate
        ) {
            $oldJobTitle = $employee->job_title;
            $oldDepartmentId = $employee->department_id;

            $event = EmployeeLifecycleEvent::create([
                'company_id' => $employee->company_id,
                'employee_id' => $employee->id,
                'created_by' => Auth::id(),
                'event_type' => 'transferred',
                'title' => 'Employee Transfer',
                'description' => $description ?? sprintf(
                    'Employee transferred from department %s to %s',
                    $oldDepartmentId ?? 'N/A',
                    $newDepartmentId ?? 'N/A'
                ),
                'effective_date' => $effectiveDate ?? now(),
                'event_data' => [
                    'old_job_title' => $oldJobTitle,
                    'new_job_title' => $newJobTitle ?? $oldJobTitle,
                    'old_department_id' => $oldDepartmentId,
                    'new_department_id' => $newDepartmentId,
                ],
            ]);

            // Update employee record
            $updates = [];
            if ($newDepartmentId !== null) {
                $updates['department_id'] = $newDepartmentId;
            }
            if ($newJobTitle !== null) {
                $updates['job_title'] = $newJobTitle;
            }
            if (!empty($updates)) {
                $employee->update($updates);
            }

            return $event;
        });
    }

    /**
     * Record a rehire event.
     */
    public function recordRehire(
        Employee $employee,
        Carbon $rehireDate,
        ?string $newJobTitle = null,
        ?int $newDepartmentId = null,
        ?string $description = null,
        ?int $relatedSalaryChangeId = null
    ): EmployeeLifecycleEvent {
        return DB::transaction(function () use (
            $employee,
            $rehireDate,
            $newJobTitle,
            $newDepartmentId,
            $description,
            $relatedSalaryChangeId
        ) {
            // Update employee status
            $employee->update([
                'employment_status' => 'active',
                'is_active' => true,
                'termination_date' => null,
                'hire_date' => $rehireDate, // Update hire date to rehire date
                'job_title' => $newJobTitle ?? $employee->job_title,
                'department_id' => $newDepartmentId ?? $employee->department_id,
            ]);

            $event = EmployeeLifecycleEvent::create([
                'company_id' => $employee->company_id,
                'employee_id' => $employee->id,
                'created_by' => Auth::id(),
                'event_type' => 'rehired',
                'title' => sprintf('Employee Rehired: %s %s', $employee->first_name, $employee->last_name),
                'description' => $description ?? sprintf(
                    'Employee %s %s was rehired on %s',
                    $employee->first_name,
                    $employee->last_name,
                    $rehireDate->format('Y-m-d')
                ),
                'effective_date' => $rehireDate,
                'related_salary_change_id' => $relatedSalaryChangeId,
                'event_data' => [
                    'previous_termination_date' => $employee->getOriginal('termination_date'),
                    'rehire_date' => $rehireDate->format('Y-m-d'),
                    'job_title' => $newJobTitle ?? $employee->job_title,
                    'department_id' => $newDepartmentId ?? $employee->department_id,
                ],
            ]);

            return $event;
        });
    }

    /**
     * Record a status change event (e.g., active to on_leave).
     */
    public function recordStatusChange(
        Employee $employee,
        string $newStatus,
        ?string $description = null,
        ?Carbon $effectiveDate = null
    ): EmployeeLifecycleEvent {
        return DB::transaction(function () use ($employee, $newStatus, $description, $effectiveDate) {
            $oldStatus = $employee->employment_status;

            $event = EmployeeLifecycleEvent::create([
                'company_id' => $employee->company_id,
                'employee_id' => $employee->id,
                'created_by' => Auth::id(),
                'event_type' => 'status_changed',
                'title' => sprintf('Status Changed: %s → %s', $oldStatus, $newStatus),
                'description' => $description ?? sprintf(
                    'Employee status changed from %s to %s',
                    $oldStatus,
                    $newStatus
                ),
                'effective_date' => $effectiveDate ?? now(),
                'event_data' => [
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                ],
            ]);

            // Update employee status
            $employee->update([
                'employment_status' => $newStatus,
                'is_active' => $newStatus === 'active',
            ]);

            return $event;
        });
    }

    /**
     * Get all lifecycle events for an employee.
     */
    public function getEmployeeHistory(Employee $employee): \Illuminate\Database\Eloquent\Collection
    {
        return EmployeeLifecycleEvent::where('employee_id', $employee->id)
            ->orderBy('effective_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Record a termination event.
     */
    public function recordTermination(
        Employee $employee,
        Carbon $terminationDate,
        string $terminationType,
        ?string $terminationReason = null,
        ?string $terminationNotes = null,
        ?int $relatedTerminationSettlementId = null
    ): EmployeeLifecycleEvent {
        return DB::transaction(function () use (
            $employee,
            $terminationDate,
            $terminationType,
            $terminationReason,
            $terminationNotes,
            $relatedTerminationSettlementId
        ) {
            $event = EmployeeLifecycleEvent::create([
                'company_id' => $employee->company_id,
                'employee_id' => $employee->id,
                'created_by' => Auth::id(),
                'event_type' => 'terminated',
                'title' => sprintf('Employee Terminated: %s %s', $employee->first_name, $employee->last_name),
                'description' => $terminationNotes ?? sprintf(
                    'Employee %s %s was terminated on %s. Reason: %s',
                    $employee->first_name,
                    $employee->last_name,
                    $terminationDate->format('Y-m-d'),
                    $terminationReason ?? 'Not specified'
                ),
                'effective_date' => $terminationDate,
                'related_termination_settlement_id' => $relatedTerminationSettlementId,
                'event_data' => [
                    'termination_type' => $terminationType,
                    'termination_reason' => $terminationReason,
                    'termination_notes' => $terminationNotes,
                    'job_title' => $employee->job_title,
                    'department_id' => $employee->department_id,
                ],
            ]);

            return $event;
        });
    }

    /**
     * Get lifecycle events by type for an employee.
     */
    public function getEmployeeEventsByType(
        Employee $employee,
        string $eventType
    ): \Illuminate\Database\Eloquent\Collection {
        return EmployeeLifecycleEvent::where('employee_id', $employee->id)
            ->where('event_type', $eventType)
            ->orderBy('effective_date', 'desc')
            ->get();
    }
}
