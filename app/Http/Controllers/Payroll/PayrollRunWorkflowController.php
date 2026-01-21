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
     * Approve a payroll run and lock its items.
     */
    public function approve(Request $request, PayrollRun $run): RedirectResponse
    {
        $this->authorize('approve', $run);

        if (! $run->canApprove()) {
            return back()->withErrors(['workflow' => 'Payroll run cannot be approved from current state.']);
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

        return back()->with('status', 'Payroll run approved and locked.');
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

