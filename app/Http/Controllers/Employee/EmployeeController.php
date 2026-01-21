<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\SalaryStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees with search and filters.
     */
    public function index(Request $request)
    {
        $query = Employee::query()->with(['user', 'currentSalaryStructure.salaryStructure']);

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('employee_code', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('job_title', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->input('status') === 'active') {
                $query->where('is_active', true);
            } elseif ($request->input('status') === 'terminated') {
                $query->where('is_active', false)
                    ->orWhereNotNull('termination_date');
            }
        }

        // Filter by employment type
        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->input('employment_type'));
        }

        // Filter by department
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->input('department_id'));
        }

        // Sort
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDir = $request->input('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        $employees = $query->paginate($request->input('per_page', 15));

        // Get filter options
        $salaryStructures = SalaryStructure::all();
        $employmentTypes = ['full_time' => 'Full Time', 'part_time' => 'Part Time', 'contract' => 'Contract', 'intern' => 'Intern', 'temporary' => 'Temporary'];

        return view('employees.index', compact('employees', 'salaryStructures', 'employmentTypes'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        $salaryStructures = SalaryStructure::all();
        return view('employees.create', compact('salaryStructures'));
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_code' => 'required|string|max:50|unique:employees,employee_code',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'national_id' => 'nullable|string|max:50',
            'hire_date' => 'required|date',
            'employment_status' => 'required|in:active,on_leave,terminated,suspended',
            'employment_type' => 'required|in:full_time,part_time,contract,intern,temporary',
            'job_title' => 'nullable|string|max:150',
            'department_id' => 'nullable|exists:departments,id',
            'pay_frequency' => 'required|in:monthly,bi_weekly,weekly',
            'tax_number' => 'nullable|string|max:100',
            'social_security_number' => 'nullable|string|max:100',
            'bank_name' => 'nullable|string|max:150',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_branch' => 'nullable|string|max:150',
            'is_active' => 'boolean',
            'salary_structure_id' => 'nullable|exists:salary_structures,id',
        ]);

        $employee = DB::transaction(function () use ($validated) {
            $employee = Employee::create($validated);

            // Assign salary structure if provided
            if (isset($validated['salary_structure_id'])) {
                $employee->employeeSalaryStructures()->create([
                    'salary_structure_id' => $validated['salary_structure_id'],
                    'effective_from' => $employee->hire_date ?? now(),
                    'is_current' => true,
                ]);
            }

            return $employee;
        });

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified employee.
     */
    public function show(Employee $employee)
    {
        $employee->load(['user', 'currentSalaryStructure.salaryStructure.components', 'payslips' => function ($q) {
            $q->latest()->limit(10);
        }]);

        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee)
    {
        $salaryStructures = SalaryStructure::all();
        $employee->load('currentSalaryStructure');
        return view('employees.edit', compact('employee', 'salaryStructures'));
    }

    /**
     * Update the specified employee.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'employee_code' => 'required|string|max:50|unique:employees,employee_code,' . $employee->id,
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'national_id' => 'nullable|string|max:50',
            'hire_date' => 'required|date',
            'termination_date' => 'nullable|date|after_or_equal:hire_date',
            'employment_status' => 'required|in:active,on_leave,terminated,suspended',
            'employment_type' => 'required|in:full_time,part_time,contract,intern,temporary',
            'job_title' => 'nullable|string|max:150',
            'department_id' => 'nullable|exists:departments,id',
            'pay_frequency' => 'required|in:monthly,bi_weekly,weekly',
            'tax_number' => 'nullable|string|max:100',
            'social_security_number' => 'nullable|string|max:100',
            'bank_name' => 'nullable|string|max:150',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_branch' => 'nullable|string|max:150',
            'is_active' => 'boolean',
            'salary_structure_id' => 'nullable|exists:salary_structures,id',
        ]);

        DB::transaction(function () use ($employee, $validated) {
            $employee->update($validated);

            // Update salary structure if changed
            if (isset($validated['salary_structure_id'])) {
                $currentStructure = $employee->currentSalaryStructure;
                if (!$currentStructure || $currentStructure->salary_structure_id != $validated['salary_structure_id']) {
                    // Mark old structure as not current
                    if ($currentStructure) {
                        $currentStructure->update(['is_current' => false]);
                    }

                    // Create new assignment
                    $employee->employeeSalaryStructures()->create([
                        'salary_structure_id' => $validated['salary_structure_id'],
                        'effective_from' => now(),
                        'is_current' => true,
                    ]);
                }
            }
        });

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified employee.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    /**
     * Get employee data for modal (AJAX).
     */
    public function get(Employee $employee)
    {
        $employee->load('currentSalaryStructure.salaryStructure');
        return response()->json([
            'id' => $employee->id,
            'employee_code' => $employee->employee_code,
            'first_name' => $employee->first_name,
            'last_name' => $employee->last_name,
            'middle_name' => $employee->middle_name,
            'email' => $employee->email,
            'phone' => $employee->phone,
            'date_of_birth' => $employee->date_of_birth?->format('Y-m-d'),
            'national_id' => $employee->national_id,
            'hire_date' => $employee->hire_date?->format('Y-m-d'),
            'termination_date' => $employee->termination_date?->format('Y-m-d'),
            'employment_status' => $employee->employment_status,
            'employment_type' => $employee->employment_type,
            'job_title' => $employee->job_title,
            'department_id' => $employee->department_id,
            'pay_frequency' => $employee->pay_frequency,
            'tax_number' => $employee->tax_number,
            'social_security_number' => $employee->social_security_number,
            'bank_name' => $employee->bank_name,
            'bank_account_number' => $employee->bank_account_number,
            'bank_branch' => $employee->bank_branch,
            'is_active' => $employee->is_active,
            'salary_structure_id' => $employee->currentSalaryStructure?->salary_structure_id,
        ]);
    }
}
