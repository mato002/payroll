<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payroll\PayrollRunPeriodRequest;
use App\Models\Employee;
use App\Services\Payroll\PayrollRunService;
use App\Tenancy\CurrentCompany;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PayrollRunWizardController extends Controller
{
    public function __construct(
        protected PayrollRunService $payrollRunService,
        protected CurrentCompany $currentCompany
    ) {
    }

    /**
     * Show the wizard (GET) for the given step.
     */
    public function create(Request $request): View
    {
        $step = (int) $request->query('step', 1);
        $step = max(1, min(4, $step));

        $wizard = $request->session()->get('payroll_run_wizard', []);

        $company = $this->currentCompany->get();

        $employees = collect();
        $preview   = collect();

        if ($step >= 2 && $company) {
            $employees = Employee::query()
                ->where('company_id', $company->id)
                ->where('employment_status', 'active')
                ->where('is_active', true)
                ->orderBy('employee_code')
                ->get();
        }

        // Step 3 preview: for now, we just show counts and placeholders.
        // Full preview is handled when the service runs in step 4.
        return view('payroll.runs.wizard', [
            'step'      => $step,
            'wizard'    => $wizard,
            'company'   => $company,
            'employees' => $employees,
            'preview'   => $preview,
        ]);
    }

    /**
     * Handle step submissions.
     */
    public function storeStep(PayrollRunPeriodRequest $request): RedirectResponse
    {
        $step = (int) $request->input('step', 1);

        $wizard = $request->session()->get('payroll_run_wizard', []);

        if ($step === 1) {
            $validated = $request->validated();

            $wizard['period_start_date'] = $validated['period_start_date'];
            $wizard['period_end_date']   = $validated['period_end_date'];
            $wizard['pay_date']          = $validated['pay_date'];
            $wizard['name']              = $validated['name'] ?? null;
            $wizard['description']       = $validated['description'] ?? null;

            $request->session()->put('payroll_run_wizard', $wizard);

            return redirect()->route('payroll.runs.wizard.create', ['step' => 2]);
        }

        if ($step === 2) {
            // In a more advanced version, allow excluding employees here
            return redirect()->route('payroll.runs.wizard.create', ['step' => 3]);
        }

        if ($step === 3) {
            // Confirm calculations preview and go to confirmation step
            return redirect()->route('payroll.runs.wizard.create', ['step' => 4]);
        }

        if ($step === 4) {
            // Final confirmation: create draft run with calculations, then submit for approval
            $company = $this->currentCompany->get();
            if (! $company) {
                return redirect()->back()->withErrors(['wizard' => 'No current company selected.']);
            }

            $periodStart = Carbon::parse($wizard['period_start_date']);
            $periodEnd   = Carbon::parse($wizard['period_end_date']);
            $payDate     = Carbon::parse($wizard['pay_date']);

            // Create draft run with calculations
            $run = $this->payrollRunService->createDraftRunWithCalculations(
                $company,
                $periodStart,
                $periodEnd,
                $payDate,
                $wizard['name'] ?? null,
                $wizard['description'] ?? null
            );

            // Submit for approval (draft → processing)
            $this->payrollRunService->submitForReview($run);

            $request->session()->forget('payroll_run_wizard');

            return redirect()
                ->route('company.admin.dashboard')
                ->with('status', 'Payroll run "' . $run->name . '" created, calculated, and submitted for approval.');
        }

        return redirect()->route('payroll.runs.wizard.create', ['step' => 1]);
    }
}

