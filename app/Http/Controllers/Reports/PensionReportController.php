<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\GeneratePensionReportRequest;
use App\Services\Reporting\ReportExporter;
use App\Services\Reporting\PensionReport;
use App\Tenancy\CurrentCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PensionReportController extends Controller
{
    public function __construct(
        protected ReportExporter $exporter
    ) {}

    /**
     * Display pension report generation form.
     */
    public function index(Request $request)
    {
        return view('reports.pension.index');
    }

    /**
     * Generate and download pension report.
     */
    public function generate(GeneratePensionReportRequest $request)
    {
        /** @var \App\Tenancy\CurrentCompany $currentCompany */
        $currentCompany = app(CurrentCompany::class);
        $company = $currentCompany->get();

        if (!$company) {
            abort(404, 'Company not found');
        }

        $periodStart = $request->input('period_start')
            ? \Carbon\Carbon::parse($request->input('period_start'))
            : null;

        $periodEnd = $request->input('period_end')
            ? \Carbon\Carbon::parse($request->input('period_end'))
            : null;

        $report = new PensionReport($company, $periodStart, $periodEnd);
        $data = $report->toCollection();

        $format = $request->input('format', 'pdf');

        if ($format === 'excel') {
            $headings = [
                'Employee Code',
                'Employee Name',
                'Social Security Number',
                'Employee Contribution',
                'Employer Contribution',
                'Total Contribution',
                'Periods',
            ];

            $mapping = function ($row) {
                return [
                    $row['employee_code'],
                    $row['employee_name'],
                    $row['social_security_number'],
                    number_format($row['employee_contribution'], 2),
                    number_format($row['employer_contribution'], 2),
                    number_format($row['total_contribution'], 2),
                    $row['periods'],
                ];
            };

            return $this->exporter->downloadExcel(
                $data->get('employees'),
                'pension-contributions-' . now()->format('Y-m-d'),
                $headings,
                $mapping
            );
        }

        // PDF format
        return $this->exporter->downloadPdf(
            $data,
            'reports.pension.pdf',
            $report->getTitle(),
            $company,
            [
                'periodStart' => $periodStart,
                'periodEnd' => $periodEnd,
                'requestedBy' => Auth::user(),
            ]
        );
    }
}
