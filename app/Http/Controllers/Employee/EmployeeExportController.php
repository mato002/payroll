<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\Employee\EmployeeImportExportService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class EmployeeExportController extends Controller
{
    public function __construct(
        protected EmployeeImportExportService $service
    ) {
        // Require authentication
        $this->middleware('auth');
    }

    /**
     * Export employees to CSV/Excel.
     */
    public function export(Request $request, Company $company): BinaryFileResponse
    {
        // Check authorization - users who can view employees can export
        $this->authorize('viewAny', \App\Models\Employee::class);

        // Validate format
        $validated = $request->validate([
            'format' => 'nullable|in:xlsx,xls,csv',
        ]);

        $format = $validated['format'] ?? 'xlsx';

        return $this->service->exportEmployees($company, $format);
    }
}
