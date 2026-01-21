<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PayrollRun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Example Controller demonstrating multi-tenancy usage
 * 
 * This controller shows how to work with tenant-scoped models.
 * All queries are automatically scoped by company_id.
 */
class ExampleTenantController extends Controller
{
    /**
     * Example: Get all employees for the current company
     * 
     * The Employee model uses BelongsToCompany trait, so this query
     * is automatically scoped to the current company.
     */
    public function getEmployees()
    {
        // This query is automatically scoped to current company
        $employees = Employee::all();
        
        // You can also use query builder - still scoped
        $activeEmployees = Employee::where('is_active', true)->get();
        
        return response()->json([
            'company' => currentCompany()->name,
            'employees' => $employees,
        ]);
    }

    /**
     * Example: Create an employee (company_id auto-filled)
     * 
     * When creating, company_id is automatically set from current company.
     */
    public function createEmployee(Request $request)
    {
        $employee = Employee::create([
            'employee_code' => $request->employee_code,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'hire_date' => $request->hire_date,
            'basic_salary' => $request->basic_salary,
            // company_id is automatically set by BelongsToCompany trait
        ]);

        return response()->json($employee);
    }

    /**
     * Example: Get payroll runs for current company
     */
    public function getPayrollRuns()
    {
        // Automatically scoped to current company
        $runs = PayrollRun::with('items.employee')
            ->where('status', 'completed')
            ->orderBy('pay_date', 'desc')
            ->get();

        return response()->json($runs);
    }

    /**
     * Example: Super admin accessing all companies (bypass scope)
     * 
     * WARNING: Only use this if user is super admin and you need
     * to access data across all companies.
     */
    public function getAllCompaniesData()
    {
        if (!Auth::user()->is_super_admin) {
            abort(403, 'Only super admins can access this');
        }

        // Bypass company scope to get all employees across all companies
        $allEmployees = Employee::withoutCompanyScope()->get();

        return response()->json($allEmployees);
    }

    /**
     * Example: Query specific company (for super admin)
     */
    public function getCompanyEmployees($companyId)
    {
        if (!Auth::user()->is_super_admin) {
            abort(403, 'Only super admins can access this');
        }

        // Query employees for a specific company
        $employees = Employee::withoutCompanyScope()
            ->where('company_id', $companyId)
            ->get();

        return response()->json($employees);
    }

    /**
     * Example: Check if model belongs to current company
     */
    public function checkEmployeeAccess($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);

        if (!$employee->belongsToCurrentCompany()) {
            abort(403, 'Employee does not belong to your company');
        }

        return response()->json($employee);
    }
}
