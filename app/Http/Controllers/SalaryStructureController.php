<?php

namespace App\Http\Controllers;

use App\Models\SalaryStructure;
use App\Models\SalaryStructureComponent;
use App\Tenancy\CurrentCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SalaryStructureController extends Controller
{
    /**
     * Display a listing of salary structures.
     */
    public function index()
    {
        $company = app(CurrentCompany::class)->get();
        
        $structures = SalaryStructure::where('company_id', $company->id())
            ->withCount('employeeAssignments')
            ->orderBy('name')
            ->get();

        return view('salary-structures.index', compact('structures'));
    }

    /**
     * Show the form for creating a new salary structure.
     */
    public function create()
    {
        $company = app(CurrentCompany::class)->get();
        
        return view('salary-structures.create', [
            'currency' => $company->currency ?? 'USD',
        ]);
    }

    /**
     * Store a newly created salary structure.
     */
    public function store(Request $request)
    {
        $company = app(CurrentCompany::class)->get();
        
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'pay_frequency' => 'required|in:monthly,biweekly,weekly,daily',
            'base_salary' => 'required|numeric|min:0',
            'allowances' => 'nullable|array',
            'allowances.*.name' => 'required|string|max:150',
            'allowances.*.calculation_type' => 'required|in:fixed,percentage_of_basic',
            'allowances.*.amount' => 'nullable|numeric|min:0|required_if:allowances.*.calculation_type,fixed',
            'allowances.*.percentage' => 'nullable|numeric|min:0|max:100|required_if:allowances.*.calculation_type,percentage_of_basic',
            'allowances.*.taxable' => 'boolean',
            'deductions' => 'nullable|array',
            'deductions.*.name' => 'required|string|max:150',
            'deductions.*.calculation_type' => 'required|in:fixed,percentage_of_basic,percentage_of_gross',
            'deductions.*.amount' => 'nullable|numeric|min:0|required_if:deductions.*.calculation_type,fixed',
            'deductions.*.percentage' => 'nullable|numeric|min:0|max:100|required_if:deductions.*.calculation_type,percentage_of_basic,percentage_of_gross',
            'deductions.*.included_in_gross' => 'boolean',
        ]);

        $structure = DB::transaction(function () use ($validated, $company) {
            // Create salary structure
            $structure = SalaryStructure::create([
                'company_id' => $company->id(),
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'pay_frequency' => $validated['pay_frequency'],
                'currency' => $company->currency ?? 'USD',
                'is_default' => false,
                'effective_from' => now(),
            ]);

            $sortOrder = 0;

            // Add base salary component
            SalaryStructureComponent::create([
                'company_id' => $company->id(),
                'salary_structure_id' => $structure->id,
                'name' => 'Basic Salary',
                'code' => 'basic_salary',
                'type' => 'earning',
                'calculation_type' => 'fixed',
                'amount' => $validated['base_salary'],
                'taxable' => true,
                'included_in_gross' => true,
                'sort_order' => $sortOrder++,
            ]);

            // Add allowances
            if (!empty($validated['allowances'])) {
                foreach ($validated['allowances'] as $allowance) {
                    SalaryStructureComponent::create([
                        'company_id' => $company->id(),
                        'salary_structure_id' => $structure->id,
                        'name' => $allowance['name'],
                        'code' => Str::slug($allowance['name'], '_'),
                        'type' => 'earning',
                        'calculation_type' => $allowance['calculation_type'],
                        'amount' => $allowance['calculation_type'] === 'fixed' ? ($allowance['amount'] ?? 0) : null,
                        'percentage' => $allowance['calculation_type'] !== 'fixed' ? ($allowance['percentage'] ?? 0) : null,
                        'taxable' => $allowance['taxable'] ?? true,
                        'included_in_gross' => true,
                        'sort_order' => $sortOrder++,
                    ]);
                }
            }

            // Add deductions
            if (!empty($validated['deductions'])) {
                foreach ($validated['deductions'] as $deduction) {
                    SalaryStructureComponent::create([
                        'company_id' => $company->id(),
                        'salary_structure_id' => $structure->id,
                        'name' => $deduction['name'],
                        'code' => Str::slug($deduction['name'], '_'),
                        'type' => 'deduction',
                        'calculation_type' => $deduction['calculation_type'],
                        'amount' => $deduction['calculation_type'] === 'fixed' ? ($deduction['amount'] ?? 0) : null,
                        'percentage' => $deduction['calculation_type'] !== 'fixed' ? ($deduction['percentage'] ?? 0) : null,
                        'taxable' => false,
                        'included_in_gross' => $deduction['included_in_gross'] ?? true,
                        'sort_order' => $sortOrder++,
                    ]);
                }
            }

            return $structure;
        });

        return redirect()->route('salary-structures.index')
            ->with('success', 'Salary structure created successfully.');
    }

    /**
     * Display the specified salary structure.
     */
    public function show(SalaryStructure $salaryStructure)
    {
        $salaryStructure->load('components', 'employeeAssignments.employee');
        
        return view('salary-structures.show', compact('salaryStructure'));
    }

    /**
     * Show the form for editing the specified salary structure.
     */
    public function edit(SalaryStructure $salaryStructure)
    {
        $salaryStructure->load('components');
        $company = app(CurrentCompany::class)->get();
        
        return view('salary-structures.edit', [
            'structure' => $salaryStructure,
            'currency' => $company->currency ?? 'USD',
        ]);
    }

    /**
     * Update the specified salary structure.
     */
    public function update(Request $request, SalaryStructure $salaryStructure)
    {
        $company = app(CurrentCompany::class)->get();
        
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'pay_frequency' => 'required|in:monthly,biweekly,weekly,daily',
            'base_salary' => 'required|numeric|min:0',
            'allowances' => 'nullable|array',
            'allowances.*.name' => 'required|string|max:150',
            'allowances.*.calculation_type' => 'required|in:fixed,percentage_of_basic',
            'allowances.*.amount' => 'nullable|numeric|min:0|required_if:allowances.*.calculation_type,fixed',
            'allowances.*.percentage' => 'nullable|numeric|min:0|max:100|required_if:allowances.*.calculation_type,percentage_of_basic',
            'allowances.*.taxable' => 'boolean',
            'deductions' => 'nullable|array',
            'deductions.*.name' => 'required|string|max:150',
            'deductions.*.calculation_type' => 'required|in:fixed,percentage_of_basic,percentage_of_gross',
            'deductions.*.amount' => 'nullable|numeric|min:0|required_if:deductions.*.calculation_type,fixed',
            'deductions.*.percentage' => 'nullable|numeric|min:0|max:100|required_if:deductions.*.calculation_type,percentage_of_basic,percentage_of_gross',
            'deductions.*.included_in_gross' => 'boolean',
        ]);

        DB::transaction(function () use ($validated, $salaryStructure, $company) {
            // Update salary structure
            $salaryStructure->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'pay_frequency' => $validated['pay_frequency'],
            ]);

            // Delete existing components
            $salaryStructure->components()->delete();

            $sortOrder = 0;

            // Add base salary component
            SalaryStructureComponent::create([
                'company_id' => $company->id(),
                'salary_structure_id' => $salaryStructure->id,
                'name' => 'Basic Salary',
                'code' => 'basic_salary',
                'type' => 'earning',
                'calculation_type' => 'fixed',
                'amount' => $validated['base_salary'],
                'taxable' => true,
                'included_in_gross' => true,
                'sort_order' => $sortOrder++,
            ]);

            // Add allowances
            if (!empty($validated['allowances'])) {
                foreach ($validated['allowances'] as $allowance) {
                    SalaryStructureComponent::create([
                        'company_id' => $company->id(),
                        'salary_structure_id' => $salaryStructure->id,
                        'name' => $allowance['name'],
                        'code' => Str::slug($allowance['name'], '_'),
                        'type' => 'earning',
                        'calculation_type' => $allowance['calculation_type'],
                        'amount' => $allowance['calculation_type'] === 'fixed' ? ($allowance['amount'] ?? 0) : null,
                        'percentage' => $allowance['calculation_type'] !== 'fixed' ? ($allowance['percentage'] ?? 0) : null,
                        'taxable' => $allowance['taxable'] ?? true,
                        'included_in_gross' => true,
                        'sort_order' => $sortOrder++,
                    ]);
                }
            }

            // Add deductions
            if (!empty($validated['deductions'])) {
                foreach ($validated['deductions'] as $deduction) {
                    SalaryStructureComponent::create([
                        'company_id' => $company->id(),
                        'salary_structure_id' => $salaryStructure->id,
                        'name' => $deduction['name'],
                        'code' => Str::slug($deduction['name'], '_'),
                        'type' => 'deduction',
                        'calculation_type' => $deduction['calculation_type'],
                        'amount' => $deduction['calculation_type'] === 'fixed' ? ($deduction['amount'] ?? 0) : null,
                        'percentage' => $deduction['calculation_type'] !== 'fixed' ? ($deduction['percentage'] ?? 0) : null,
                        'taxable' => false,
                        'included_in_gross' => $deduction['included_in_gross'] ?? true,
                        'sort_order' => $sortOrder++,
                    ]);
                }
            }
        });

        return redirect()->route('salary-structures.index')
            ->with('success', 'Salary structure updated successfully.');
    }

    /**
     * Remove the specified salary structure.
     */
    public function destroy(SalaryStructure $salaryStructure)
    {
        // Check if structure is assigned to any employees
        if ($salaryStructure->employeeAssignments()->exists()) {
            return redirect()->route('salary-structures.index')
                ->with('error', 'Cannot delete salary structure that is assigned to employees.');
        }

        $salaryStructure->delete();

        return redirect()->route('salary-structures.index')
            ->with('success', 'Salary structure deleted successfully.');
    }
}
