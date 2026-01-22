<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\PayrollItem;
use App\Models\PayrollRun;
use App\Models\User;
use App\Notifications\PayrollCompletedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollRunWorkflowController extends Controller
{
    /**
     * Move a payroll run from draft to review (processing).
     */
    public function submitForReview(Request $request, PayrollRun $run): RedirectResponse
    {
        $this->authorize('submitForReview', $run);

        if (! $run->canSubmitForReview()) {
            return back()->withErrors(['workflow' => 'Payroll run cannot be submitted for review from current state.']);
        }

        $run->status = 'processing'; // review stage
        $run->save();

        return back()->with('status', 'Payroll run submitted for review.');
    }

    /**
     * Show the payroll review page.
     */
    public function show(PayrollRun $run)
    {
        $this->authorize('view', $run);

        // Load relationships
        $run->load(['items.employee', 'items.details', 'company']);

        // Get previous payroll run for comparison
        $previousRun = PayrollRun::where('company_id', $run->company_id)
            ->where('id', '<', $run->id)
            ->whereIn('status', ['completed', 'closed'])
            ->orderBy('id', 'desc')
            ->first();

        // Calculate summary statistics
        $summary = [
            'total_employees' => $run->items()->count(),
            'total_gross' => (float) $run->total_gross_amount,
            'total_net' => (float) $run->total_net_amount,
            'total_earnings' => (float) $run->items()->sum('total_earnings'),
            'total_deductions' => (float) $run->items()->sum('total_deductions'),
            'total_contributions' => (float) $run->items()->sum('total_contributions'),
        ];

        // Calculate differences if previous run exists
        $differences = null;
        if ($previousRun) {
            $differences = [
                'employee_count' => $summary['total_employees'] - $previousRun->items()->count(),
                'gross_amount' => $summary['total_gross'] - (float) $previousRun->total_gross_amount,
                'net_amount' => $summary['total_net'] - (float) $previousRun->total_net_amount,
            ];
        }

        return view('payroll.runs.review', [
            'run' => $run,
            'previousRun' => $previousRun,
            'summary' => $summary,
            'differences' => $differences,
        ]);
    }

    /**
     * Reject a payroll run and return it to draft.
     */
    public function reject(Request $request, PayrollRun $run): RedirectResponse
    {
        $this->authorize('approve', $run);

        if (! $run->canApprove()) {
            return back()->withErrors(['workflow' => 'Payroll run cannot be rejected from current state.']);
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $run->status = 'draft';
        $run->description = ($run->description ? $run->description . "\n\n" : '') . 
            'Rejected: ' . $request->input('rejection_reason');
        $run->save();

        return back()->with('status', 'Payroll run rejected and returned to draft.');
    }

    /**
     * Approve a payroll run with optional comments.
     */
    public function approve(Request $request, PayrollRun $run): RedirectResponse
    {
        $this->authorize('approve', $run);

        if (! $run->canApprove()) {
            return back()->withErrors(['workflow' => 'Payroll run cannot be approved from current state.']);
        }

        // Update description with approval comments if provided
        if ($request->filled('approval_comments')) {
            $run->description = ($run->description ? $run->description . "\n\n" : '') . 
                'Approval notes: ' . $request->input('approval_comments');
        }

        $run->status      = 'completed'; // approved & ready to pay
        $run->approved_by = Auth::id();
        $run->approved_at = now();
        $run->save();

        // Lock all payroll items for this run
        PayrollItem::where('payroll_run_id', $run->id)
            ->update(['status' => 'locked']);

        // Notify company admins and payroll managers
        $recipients = User::whereHas('companies', function ($q) use ($run) {
                $q->where('companies.id', $run->company_id);
            })
            ->whereHas('roles', function ($q) use ($run) {
                $q->whereHas('company', function ($q2) use ($run) {
                    $q2->where('companies.id', $run->company_id);
                })->whereIn('slug', ['company_admin', 'payroll_manager']);
            })
            ->get();

        foreach ($recipients as $user) {
            $user->notify(new PayrollCompletedNotification($run));
        }

        return redirect()->route('company.admin.dashboard', ['company' => $run->company->slug])
            ->with('status', 'Payroll run approved and locked.');
    }

    /**
     * Lock (close) a payroll run after payments are processed.
     */
    public function close(Request $request, PayrollRun $run): RedirectResponse
    {
        $this->authorize('approve', $run);

        if (! $run->canLock()) {
            return back()->withErrors(['workflow' => 'Payroll run cannot be closed from current state.']);
        }

        $run->status = 'closed';
        $run->save();

        return back()->with('status', 'Payroll run closed.');
    }
}

