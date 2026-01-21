<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\Employee\EmployeeImportExportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeImportController extends Controller
{
    public function __construct(
        protected EmployeeImportExportService $service
    ) {
        // Require authentication
        $this->middleware('auth');
    }

    /**
     * Show import form (if you have a view).
     */
    public function create(Company $company)
    {
        // Check authorization - only company admins can import
        $this->authorize('create', \App\Models\Employee::class);

        return view('employees.import', compact('company'));
    }

    /**
     * Process employee import from uploaded file.
     */
    public function store(Request $request, Company $company): JsonResponse
    {
        // Check authorization - only company admins can import
        $this->authorize('create', \App\Models\Employee::class);

        // Validate file upload
        $validated = $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240', // 10MB max
            ],
        ]);

        // Process import
        $result = $this->service->importEmployees($company, $validated['file']);

        if ($result['success']) {
            return response()->json([
                'message'       => sprintf(
                    'Import completed. %d employees imported successfully, %d failed.',
                    $result['success_count'],
                    $result['failure_count']
                ),
                'success_count' => $result['success_count'],
                'failure_count' => $result['failure_count'],
                'failures'      => $result['failures'],
            ], 200);
        }

        return response()->json([
            'message' => $result['error'] ?? 'Import failed',
            'error'   => true,
        ], 422);
    }

    /**
     * Download import template.
     */
    public function downloadTemplate(Company $company)
    {
        // Check authorization - only company admins can download template
        $this->authorize('create', \App\Models\Employee::class);

        return $this->service->generateImportTemplate($company);
    }
}
