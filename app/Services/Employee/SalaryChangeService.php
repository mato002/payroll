<?php

namespace App\Services\Employee;

use App\Models\Employee;
use App\Models\EmployeeSalaryStructure;
use App\Models\SalaryChangeHistory;
use App\Models\SalaryStructure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalaryChangeService
{
    /**
     * Record a salary change with full history tracking.
     */
    public function recordSalaryChange(
        Employee $employee,
        SalaryStructure $newSalaryStructure,
        Carbon $effectiveFrom,
        string $changeReason,
        ?string $reasonNotes = null,
        ?SalaryStructure $oldSalaryStructure = null,
        ?EmployeeSalaryStructure $oldEmployeeSalaryStructure = null,
        ?Carbon $effectiveTo = null
    ): SalaryChangeHistory {
        return DB::transaction(function () use (
            $employee,
            $newSalaryStructure,
            $effectiveFrom,
            $changeReason,
            $reasonNotes,
            $oldSalaryStructure,
            $oldEmployeeSalaryStructure,
            $effectiveTo
        ) {
            // Get current employee salary structure if not provided
            if ($oldEmployeeSalaryStructure === null) {
                $oldEmployeeSalaryStructure = EmployeeSalaryStructure::where('employee_id', $employee->id)
                    ->where('is_current', true)
                    ->where('company_id', $employee->company_id)
                    ->first();
            }

            // Get old salary structure if not provided
            if ($oldSalaryStructure === null && $oldEmployeeSalaryStructure) {
                $oldSalaryStructure = $oldEmployeeSalaryStructure->salaryStructure;
            }

            // Calculate old salary totals
            $oldTotalGross = 0;
            $oldTotalNet = 0;
            $oldComponents = [];

            if ($oldEmployeeSalaryStructure) {
                $oldComponents = $this->getSalaryComponentsSnapshot($oldEmployeeSalaryStructure);
                $oldTotalGross = $this->calculateTotalGross($oldComponents);
                $oldTotalNet = $this->calculateTotalNet($oldComponents);
            }

            // Create new employee salary structure
            // First, mark old one as not current
            if ($oldEmployeeSalaryStructure) {
                $oldEmployeeSalaryStructure->update([
                    'is_current' => false,
                    'effective_to' => $effectiveFrom->copy()->subDay(),
                ]);
            }

            // Create new employee salary structure
            $newEmployeeSalaryStructure = EmployeeSalaryStructure::create([
                'company_id' => $employee->company_id,
                'employee_id' => $employee->id,
                'salary_structure_id' => $newSalaryStructure->id,
                'effective_from' => $effectiveFrom,
                'effective_to' => $effectiveTo,
                'is_current' => $effectiveTo === null,
            ]);

            // Get new salary components
            $newComponents = $this->getSalaryComponentsSnapshot($newEmployeeSalaryStructure);
            $newTotalGross = $this->calculateTotalGross($newComponents);
            $newTotalNet = $this->calculateTotalNet($newComponents);

            // Calculate percentage change
            $percentageChange = null;
            if ($oldTotalGross > 0) {
                $percentageChange = (($newTotalGross - $oldTotalGross) / $oldTotalGross) * 100;
            }

            // Record the salary change history
            $history = SalaryChangeHistory::create([
                'company_id' => $employee->company_id,
                'employee_id' => $employee->id,
                'created_by' => Auth::id(),
                'old_salary_structure_id' => $oldSalaryStructure?->id,
                'new_salary_structure_id' => $newSalaryStructure->id,
                'old_employee_salary_structure_id' => $oldEmployeeSalaryStructure?->id,
                'new_employee_salary_structure_id' => $newEmployeeSalaryStructure->id,
                'change_reason' => $changeReason,
                'reason_notes' => $reasonNotes,
                'effective_from' => $effectiveFrom,
                'effective_to' => $effectiveTo,
                'old_salary_components' => $oldComponents,
                'new_salary_components' => $newComponents,
                'old_total_gross' => $oldTotalGross,
                'new_total_gross' => $newTotalGross,
                'old_total_net' => $oldTotalNet,
                'new_total_net' => $newTotalNet,
                'percentage_change' => $percentageChange,
            ]);

            return $history;
        });
    }

    /**
     * Get salary change history for an employee.
     */
    public function getEmployeeSalaryHistory(Employee $employee): \Illuminate\Database\Eloquent\Collection
    {
        return SalaryChangeHistory::where('employee_id', $employee->id)
            ->orderBy('effective_from', 'desc')
            ->with(['oldSalaryStructure', 'newSalaryStructure'])
            ->get();
    }

    /**
     * Get current salary structure for an employee.
     */
    public function getCurrentSalaryStructure(Employee $employee): ?EmployeeSalaryStructure
    {
        return EmployeeSalaryStructure::where('employee_id', $employee->id)
            ->where('company_id', $employee->company_id)
            ->where('is_current', true)
            ->where(function ($query) {
                $query->whereNull('effective_to')
                    ->orWhere('effective_to', '>=', now());
            })
            ->with(['salaryStructure.components'])
            ->first();
    }

    /**
     * Get salary structure effective on a specific date.
     */
    public function getSalaryStructureOnDate(
        Employee $employee,
        Carbon $date
    ): ?EmployeeSalaryStructure {
        return EmployeeSalaryStructure::where('employee_id', $employee->id)
            ->where('company_id', $employee->company_id)
            ->where('effective_from', '<=', $date)
            ->where(function ($query) use ($date) {
                $query->whereNull('effective_to')
                    ->orWhere('effective_to', '>=', $date);
            })
            ->orderBy('effective_from', 'desc')
            ->with(['salaryStructure.components'])
            ->first();
    }

    /**
     * Get a snapshot of salary components for an employee salary structure.
     */
    protected function getSalaryComponentsSnapshot(EmployeeSalaryStructure $employeeSalaryStructure): array
    {
        $components = [];
        $structure = $employeeSalaryStructure->salaryStructure;

        if (!$structure) {
            return $components;
        }

        // Load components if not already loaded
        if (!$structure->relationLoaded('components')) {
            $structure->load('components');
        }

        foreach ($structure->components as $component) {
            // Check for employee-specific overrides
            $employeeComponent = $employeeSalaryStructure->components()
                ->where('salary_structure_component_id', $component->id)
                ->first();

            $amount = $employeeComponent?->override_amount ?? $component->amount;
            $percentage = $employeeComponent?->override_percentage ?? $component->percentage;

            $components[] = [
                'id' => $component->id,
                'code' => $component->code,
                'name' => $component->name,
                'type' => $component->type,
                'calculation_type' => $component->calculation_type,
                'amount' => $amount,
                'percentage' => $percentage,
                'taxable' => $component->taxable,
                'included_in_gross' => $component->included_in_gross,
            ];
        }

        return $components;
    }

    /**
     * Calculate total gross from components.
     */
    protected function calculateTotalGross(array $components): float
    {
        $total = 0;

        foreach ($components as $component) {
            if ($component['included_in_gross'] && $component['type'] === 'earning') {
                $amount = $component['amount'] ?? 0;
                $total += (float) $amount;
            }
        }

        return $total;
    }

    /**
     * Calculate total net from components.
     */
    protected function calculateTotalNet(array $components): float
    {
        $gross = $this->calculateTotalGross($components);
        $deductions = 0;
        $contributions = 0;

        foreach ($components as $component) {
            if ($component['type'] === 'deduction') {
                $amount = $component['amount'] ?? 0;
                $deductions += (float) $amount;
            } elseif ($component['type'] === 'contribution') {
                $amount = $component['amount'] ?? 0;
                $contributions += (float) $amount;
            }
        }

        return $gross - $deductions - $contributions;
    }
}
