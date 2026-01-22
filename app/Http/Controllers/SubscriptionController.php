<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    /**
     * Display subscription management page
     */
    public function index()
    {
        $company = currentCompany();
        
        if (!$company) {
            abort(404, 'Company not found');
        }

        $currentSubscription = $company->subscriptions()
            ->with('plan')
            ->whereIn('status', ['active', 'trial', 'past_due'])
            ->latest()
            ->first();

        $allPlans = SubscriptionPlan::orderBy('base_price')->get();
        
        $invoices = $company->invoices()
            ->with(['subscription', 'items'])
            ->orderBy('issue_date', 'desc')
            ->limit(20)
            ->get();

        $recentPayments = Payment::where('company_id', $company->id)
            ->with('invoice')
            ->orderBy('payment_date', 'desc')
            ->limit(10)
            ->get();

        return view('subscriptions.index', [
            'company' => $company,
            'currentSubscription' => $currentSubscription,
            'plans' => $allPlans,
            'invoices' => $invoices,
            'recentPayments' => $recentPayments,
        ]);
    }

    /**
     * Show upgrade/downgrade confirmation page
     */
    public function showChangePlan(SubscriptionPlan $plan)
    {
        $company = currentCompany();
        
        if (!$company) {
            abort(404, 'Company not found');
        }

        $currentSubscription = $company->subscriptions()
            ->with('plan')
            ->whereIn('status', ['active', 'trial', 'past_due'])
            ->latest()
            ->first();

        if (!$currentSubscription) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'No active subscription found.');
        }

        $isUpgrade = $plan->base_price > $currentSubscription->plan->base_price;
        $isDowngrade = $plan->base_price < $currentSubscription->plan->base_price;

        return view('subscriptions.change-plan', [
            'company' => $company,
            'currentSubscription' => $currentSubscription,
            'newPlan' => $plan,
            'isUpgrade' => $isUpgrade,
            'isDowngrade' => $isDowngrade,
        ]);
    }

    /**
     * Process plan change
     */
    public function changePlan(Request $request, SubscriptionPlan $plan)
    {
        $company = currentCompany();
        
        if (!$company) {
            abort(404, 'Company not found');
        }

        $currentSubscription = $company->subscriptions()
            ->whereIn('status', ['active', 'trial', 'past_due'])
            ->latest()
            ->first();

        if (!$currentSubscription) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'No active subscription found.');
        }

        $request->validate([
            'confirm' => 'required|accepted',
        ]);

        DB::transaction(function () use ($company, $currentSubscription, $plan) {
            // Mark current subscription as canceled
            $currentSubscription->update([
                'status' => 'canceled',
                'end_date' => now(),
            ]);

            // Create new subscription
            Subscription::create([
                'company_id' => $company->id,
                'plan_code' => $plan->code,
                'billing_cycle' => $currentSubscription->billing_cycle ?? 'monthly',
                'status' => 'active',
                'start_date' => now(),
                'end_date' => $plan->billing_model === 'monthly' 
                    ? now()->addMonth() 
                    : now()->addYear(),
                'next_billing_date' => $plan->billing_model === 'monthly' 
                    ? now()->addMonth() 
                    : now()->addYear(),
                'base_price' => $plan->base_price,
                'per_employee_price' => $plan->price_per_employee,
                'max_employees_included' => $plan->max_employees,
                'currency' => $plan->currency ?? $company->currency ?? 'USD',
                'auto_renew' => true,
            ]);

            // Update company subscription status
            $company->update([
                'subscription_status' => 'active',
            ]);
        });

        return redirect()->route('subscriptions.index')
            ->with('success', 'Subscription plan changed successfully.');
    }

    /**
     * Download invoice PDF
     */
    public function downloadInvoice(Invoice $invoice)
    {
        $company = currentCompany();
        
        if (!$company || $invoice->company_id !== $company->id) {
            abort(403, 'Unauthorized');
        }

        // Load relationships
        $invoice->load(['items', 'company']);

        // For now, return a simple response
        // In production, you'd generate a PDF using a library like DomPDF or Snappy
        return response()->streamDownload(function () use ($invoice) {
            echo view('subscriptions.invoice-pdf', ['invoice' => $invoice])->render();
        }, "invoice-{$invoice->invoice_number}.pdf", [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Cancel subscription
     */
    public function cancel(Request $request)
    {
        $company = currentCompany();
        
        if (!$company) {
            abort(404, 'Company not found');
        }

        $currentSubscription = $company->subscriptions()
            ->whereIn('status', ['active', 'trial', 'past_due'])
            ->latest()
            ->first();

        if (!$currentSubscription) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'No active subscription found.');
        }

        $request->validate([
            'confirm' => 'required|accepted',
        ]);

        $currentSubscription->update([
            'status' => 'canceled',
            'end_date' => now(),
            'auto_renew' => false,
        ]);

        $company->update([
            'subscription_status' => 'canceled',
        ]);

        return redirect()->route('subscriptions.index')
            ->with('success', 'Subscription canceled successfully.');
    }
}
