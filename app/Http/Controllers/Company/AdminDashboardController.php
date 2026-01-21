<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\PayrollRun;
use App\Models\Payslip;
use Illuminate\Support\Carbon;

class AdminDashboardController extends Controller
{
    public function __invoke()
    {
        $companyId = currentCompanyId();

        // Basic metrics
        $employeeCount = Employee::query()
            ->where('company_id', $companyId)
            ->where('is_active', true)
            ->count();

        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth   = $now->copy()->endOfMonth();

        // Total net amount for payroll runs in the current month
        $monthlyPayroll = PayrollRun::query()
            ->where('company_id', $companyId)
            ->whereBetween('pay_date', [$startOfMonth, $endOfMonth])
            ->sum('total_net_amount');

        // Recent payroll runs
        $runs = PayrollRun::query()
            ->where('company_id', $companyId)
            ->orderByDesc('pay_date')
            ->limit(10)
            ->get();

        // Pending approvals: payroll runs in "processing" plus payslips without "sent/viewed" status
        $pendingPayrollApprovals = PayrollRun::query()
            ->where('company_id', $companyId)
            ->where('status', 'processing')
            ->count();

        $pendingPayslipApprovals = Payslip::query()
            ->where('company_id', $companyId)
            ->whereIn('status', ['generated'])
            ->count();

        $pendingApprovalsTotal = $pendingPayrollApprovals + $pendingPayslipApprovals;

        return view('company.admin.dashboard', [
            'employeeCount'          => $employeeCount,
            'monthlyPayroll'         => $monthlyPayroll,
            'runs'                   => $runs,
            'pendingPayrollApprovals'=> $pendingPayrollApprovals,
            'pendingPayslipApprovals'=> $pendingPayslipApprovals,
            'pendingApprovalsTotal'  => $pendingApprovalsTotal,
            'monthLabel'             => format_localized_date($startOfMonth, 'F Y'),
        ]);
    }
}

