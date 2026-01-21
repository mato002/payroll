<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\GenerateTaxReportRequest;
use App\Services\Reporting\ReportExporter;
use App\Services\Reporting\TaxSummaryReport;
use App\Tenancy\CurrentCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaxReportController extends Controller
{
    public function __construct(
        protected ReportExporter $exporter
    ) {}

    /**
     * Display tax report generation form.
     */
    public function index(Request $request)
    {
        return view('reports.tax.index');
    }

    /**
     * Generate and download tax report.
     */
    public function generate(GenerateTaxReportRequest $request)
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

        $report = new TaxSummaryReport($company, $periodStart, $periodEnd);
        $data = $report->toCollection();

        $format = $request->input('format', 'pdf');

        if ($format === 'excel') {
            $headings = [
                'Employee Code',
                'Employee Name',
                'Tax Number',
                'Total Gross',
                'Total Tax',
                'Periods',
            ];

            $mapping = function ($row) {
                return [
                    $row['employee_code'],
                    $row['employee_name'],
                    $row['tax_number'],
                    number_format($row['total_gross'], 2),
                    number_format($row['total_tax'], 2),
                    $row['periods'],
                ];
            };

            return $this->exporter->downloadExcel(
                $data->get('employees'),
                'tax-summary-' . now()->format('Y-m-d'),
                $headings,
                $mapping
            );
        }

        // PDF format
        return $this->exporter->downloadPdf(
            $data,
            'reports.tax.pdf',
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
