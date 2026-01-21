<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\GenerateAnnualReportRequest;
use App\Services\Reporting\AnnualPayrollSummaryReport;
use App\Services\Reporting\ReportExporter;
use App\Tenancy\CurrentCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnualPayrollReportController extends Controller
{
    public function __construct(
        protected ReportExporter $exporter
    ) {}

    /**
     * Display annual report generation form.
     */
    public function index(Request $request)
    {
        return view('reports.annual.index');
    }

    /**
     * Generate and download annual payroll summary report.
     */
    public function generate(GenerateAnnualReportRequest $request)
    {
        /** @var \App\Tenancy\CurrentCompany $currentCompany */
        $currentCompany = app(CurrentCompany::class);
        $company = $currentCompany->get();

        if (!$company) {
            abort(404, 'Company not found');
        }

        $year = $request->input('year', now()->year);

        $report = new AnnualPayrollSummaryReport($company, (int) $year);
        $data = $report->toCollection();

        $format = $request->input('format', 'pdf');

        if ($format === 'excel') {
            $headings = [
                'Employee Code',
                'Employee Name',
                'Tax Number',
                'SSN',
                'Total Gross',
                'Total Earnings',
                'Total Tax',
                'Total Pension',
                'Other Deductions',
                'Total Deductions',
                'Total Net',
                'Payslips',
            ];

            $mapping = function ($row) {
                return [
                    $row['employee_code'],
                    $row['employee_name'],
                    $row['tax_number'],
                    $row['social_security_number'],
                    number_format($row['total_gross'], 2),
                    number_format($row['total_earnings'], 2),
                    number_format($row['total_tax'], 2),
                    number_format($row['total_pension'], 2),
                    number_format($row['other_deductions'], 2),
                    number_format($row['total_deductions'], 2),
                    number_format($row['total_net'], 2),
                    $row['payslip_count'],
                ];
            };

            return $this->exporter->downloadExcel(
                $data->get('employees'),
                'annual-payroll-summary-' . $year,
                $headings,
                $mapping
            );
        }

        // PDF format
        return $this->exporter->downloadPdf(
            $data,
            'reports.annual.pdf',
            $report->getTitle(),
            $company,
            [
                'year' => $year,
                'requestedBy' => Auth::user(),
            ]
        );
    }
}
