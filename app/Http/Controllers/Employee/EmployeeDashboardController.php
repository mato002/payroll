<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Payslip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeDashboardController extends Controller
{
    /**
     * Show the employee dashboard with summary information.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (! $employee) {
            abort(404, 'Employee record not found for this user.');
        }

        // Recent payslips (last 5)
        $recentPayslips = Payslip::query()
            ->where('employee_id', $employee->id)
            ->orderByDesc('issue_date')
            ->limit(5)
            ->get();

        // Total payslips count
        $totalPayslips = Payslip::query()
            ->where('employee_id', $employee->id)
            ->count();

        // Latest payslip
        $latestPayslip = Payslip::query()
            ->where('employee_id', $employee->id)
            ->orderByDesc('issue_date')
            ->first();

        // Unread notifications count
        $unreadNotificationsCount = $user->unreadNotifications()->count();

        return view('employee.dashboard', [
            'employee'                => $employee,
            'recentPayslips'          => $recentPayslips,
            'totalPayslips'          => $totalPayslips,
            'latestPayslip'          => $latestPayslip,
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    }
}
