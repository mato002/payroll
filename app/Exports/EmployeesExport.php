<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class EmployeesExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    use Exportable;

    public function __construct(
        protected Company $company
    ) {
    }

    /**
     * Query employees for export.
     * Secure: scope to company; exclude sensitive encrypted fields.
     */
    public function query()
    {
        return Employee::query()
            ->where('company_id', $this->company->id)
            ->select([
                'id',
                'employee_code',
                'first_name',
                'last_name',
                'middle_name',
                'email',
                'phone',
                'date_of_birth',
                'hire_date',
                'termination_date',
                'employment_status',
                'employment_type',
                'department_id',
                'job_title',
                'pay_frequency',
                'is_active',
            ])
            ->orderBy('employee_code');
    }

    /**
     * Define column headings.
     */
    public function headings(): array
    {
        return [
            'Employee Code',
            'First Name',
            'Last Name',
            'Middle Name',
            'Email',
            'Phone',
            'Date of Birth',
            'Hire Date',
            'Termination Date',
            'Employment Status',
            'Employment Type',
            'Department ID',
            'Job Title',
            'Pay Frequency',
            'Is Active',
        ];
    }

    /**
     * Map employee data to export row.
     */
    public function map($employee): array
    {
        return [
            $employee->employee_code,
            $employee->first_name,
            $employee->last_name,
            $employee->middle_name ?? '',
            $employee->email ?? '',
            $employee->phone ?? '',
            $employee->date_of_birth ? $employee->date_of_birth->format('Y-m-d') : '',
            $employee->hire_date ? $employee->hire_date->format('Y-m-d') : '',
            $employee->termination_date ? $employee->termination_date->format('Y-m-d') : '',
            $employee->employment_status,
            $employee->employment_type,
            $employee->department_id ?? '',
            $employee->job_title ?? '',
            $employee->pay_frequency,
            $employee->is_active ? 'Yes' : 'No',
        ];
    }

    /**
     * Apply styles to the export.
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E0E0E0'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }
}
