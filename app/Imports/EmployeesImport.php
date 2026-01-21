<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeesImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure,
    SkipsOnError,
    WithChunkReading
{
    use Importable;
    use SkipsErrors;
    use SkipsFailures;

    protected int $rowsProcessed = 0;

    public function __construct(
        protected Company $company,
        protected ?int $createdByUserId = null,
    ) {
        $this->createdByUserId ??= Auth::id();
    }

    /**
     * Map each row to an Employee model.
     * Secure: only whitelisted fields are mass-assigned.
     */
    public function model(array $row): ?Employee
    {
        // Basic safeguard: ignore completely empty rows
        if (empty($row['employee_code']) && empty($row['email'])) {
            return null;
        }

        $this->rowsProcessed++;

        return new Employee([
            'company_id'        => $this->company->id,
            'employee_code'    => $this->normalizeString($row['employee_code'] ?? ''),
            'first_name'       => $this->normalizeString($row['first_name'] ?? ''),
            'last_name'        => $this->normalizeString($row['last_name'] ?? ''),
            'middle_name'      => $this->normalizeString($row['middle_name'] ?? null),
            'email'            => $this->normalizeString($row['email'] ?? null),
            'phone'            => $this->normalizeString($row['phone'] ?? null),
            'date_of_birth'    => $this->parseDate($row['date_of_birth'] ?? null),
            'hire_date'        => $this->parseDate($row['hire_date'] ?? now()->toDateString()),
            'employment_status' => $this->normalizeString($row['employment_status'] ?? 'active'),
            'employment_type'  => $this->normalizeString($row['employment_type'] ?? 'full_time'),
            'department_id'    => $this->parseInt($row['department_id'] ?? null),
            'job_title'        => $this->normalizeString($row['job_title'] ?? null),
            'pay_frequency'    => $this->normalizeString($row['pay_frequency'] ?? 'monthly'),
            'is_active'        => $this->parseBoolean($row['is_active'] ?? true),
        ]);
    }

    /**
     * Per-row validation rules.
     * Uses column names from heading row.
     */
    public function rules(): array
    {
        return [
            'employee_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('employees', 'employee_code')
                    ->where('company_id', $this->company->id)
                    ->whereNull('deleted_at'),
            ],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('employees', 'email')
                    ->where('company_id', $this->company->id)
                    ->whereNull('deleted_at'),
            ],
            'phone'             => ['nullable', 'string', 'max:50'],
            'date_of_birth'     => ['nullable', 'date'],
            'hire_date'         => ['nullable', 'date'],
            'employment_status' => ['nullable', Rule::in(['active', 'terminated', 'on_leave', 'probation'])],
            'employment_type'   => ['nullable', Rule::in(['full_time', 'part_time', 'contractor', 'intern'])],
            'pay_frequency'     => ['nullable', Rule::in(['monthly', 'bi_weekly', 'weekly', 'custom'])],
            'is_active'        => ['nullable', 'boolean'],
        ];
    }

    /**
     * Custom validation messages for clearer error reporting.
     */
    public function customValidationMessages(): array
    {
        return [
            'employee_code.required' => 'Employee code is required.',
            'employee_code.unique'   => 'Employee code already exists for this company.',
            'first_name.required'    => 'First name is required.',
            'last_name.required'     => 'Last name is required.',
            'email.email'            => 'Email format is invalid.',
            'email.unique'           => 'Email already exists for this company.',
            'employment_status.in'   => 'Employment status must be one of: active, terminated, on_leave, probation.',
            'employment_type.in'    => 'Employment type must be one of: full_time, part_time, contractor, intern.',
            'pay_frequency.in'      => 'Pay frequency must be one of: monthly, bi_weekly, weekly, custom.',
        ];
    }

    /**
     * Secure + memory-safe: process in chunks.
     */
    public function chunkSize(): int
    {
        return 500;
    }

    /**
     * Get the number of rows processed (excluding skipped rows).
     */
    public function getRowsProcessed(): int
    {
        return $this->rowsProcessed;
    }

    /**
     * Normalize string values (trim whitespace).
     */
    protected function normalizeString(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $trimmed = trim((string) $value);

        return $trimmed === '' ? null : $trimmed;
    }

    /**
     * Parse date value from various formats.
     */
    protected function parseDate(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            // Try to parse common date formats
            $date = \Carbon\Carbon::parse($value);

            return $date->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Parse integer value.
     */
    protected function parseInt(?string $value): ?int
    {
        if (empty($value)) {
            return null;
        }

        $int = filter_var($value, FILTER_VALIDATE_INT);

        return $int !== false ? $int : null;
    }

    /**
     * Parse boolean value.
     */
    protected function parseBoolean($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_string($value)) {
            $lower = strtolower(trim($value));

            return in_array($lower, ['1', 'true', 'yes', 'y', 'active'], true);
        }

        return (bool) $value;
    }
}
