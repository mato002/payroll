<?php

namespace App\Services\Employee;

use App\Exports\EmployeesExport;
use App\Imports\EmployeesImport;
use App\Models\Company;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class EmployeeImportExportService
{
    /**
     * Import employees from CSV/Excel file.
     * Returns structured result with row-level error reporting.
     */
    public function importEmployees(Company $company, UploadedFile $file): array
    {
        try {
            $import = new EmployeesImport($company);

            // Process import with error collection
            Excel::import($import, $file);

            // Collect failures with detailed row information
            $failures = $import->failures()->map(function ($failure) {
                return [
                    'row'       => $failure->row(),              // Row number in file
                    'errors'    => $failure->errors(),           // Array of validation error messages
                    'attribute' => $failure->attribute(),         // The column/field that failed
                    'values'    => $failure->values(),           // Original row data
                ];
            })->toArray();

            $successCount = $import->getRowsProcessed() - count($failures);

            // Log import summary
            Log::info('Employee import completed', [
                'company_id'    => $company->id,
                'success_count' => $successCount,
                'failure_count' => count($failures),
            ]);

            return [
                'success'       => true,
                'success_count' => max(0, $successCount),
                'failure_count' => count($failures),
                'failures'      => $failures,
                'total_rows'    => $import->getRowsProcessed(),
            ];
        } catch (\Exception $e) {
            Log::error('Employee import failed', [
                'company_id' => $company->id,
                'error'      => $e->getMessage(),
                'trace'      => $e->getTraceAsString(),
            ]);

            return [
                'success'       => false,
                'success_count' => 0,
                'failure_count' => 0,
                'failures'      => [],
                'error'         => 'Import failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Export employees to CSV/Excel file.
     */
    public function exportEmployees(Company $company, string $format = 'xlsx'): BinaryFileResponse
    {
        $fileName = sprintf('employees_%s_%s.%s', $company->slug, now()->format('Ymd_His'), $format);

        $export = new EmployeesExport($company);

        // Determine export format
        $excelFormat = match ($format) {
            'csv'  => \Maatwebsite\Excel\Excel::CSV,
            'xls'  => \Maatwebsite\Excel\Excel::XLS,
            default => \Maatwebsite\Excel\Excel::XLSX,
        };

        Log::info('Employee export initiated', [
            'company_id' => $company->id,
            'format'     => $format,
        ]);

        return $export->download($fileName, $excelFormat);
    }

    /**
     * Generate a template file for import.
     */
    public function generateImportTemplate(Company $company): BinaryFileResponse
    {
        $fileName = 'employee_import_template.xlsx';

        // Create template data with headers and example row
        $templateData = [
            [
                'employee_code',
                'first_name',
                'last_name',
                'middle_name',
                'email',
                'phone',
                'date_of_birth',
                'hire_date',
                'employment_status',
                'employment_type',
                'department_id',
                'job_title',
                'pay_frequency',
                'is_active',
            ],
            [
                'EMP001',
                'John',
                'Doe',
                'Michael',
                'john.doe@example.com',
                '+1234567890',
                '1990-01-15',
                now()->format('Y-m-d'),
                'active',
                'full_time',
                '',
                'Software Engineer',
                'monthly',
                'Yes',
            ],
        ];

        $templateClass = new class($templateData) implements FromArray {
            public function __construct(protected array $data) {}

            public function array(): array
            {
                return $this->data;
            }
        };

        return Excel::download($templateClass, $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }
}
