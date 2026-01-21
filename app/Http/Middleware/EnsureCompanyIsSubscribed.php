<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use App\Tenancy\CurrentCompany;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanyIsSubscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Tenancy\CurrentCompany $currentCompany */
        $currentCompany = app(CurrentCompany::class);

        $company = $currentCompany->get();

        // If no company context, skip (public or super admin routes)
        if (! $company) {
            return $next($request);
        }

        // Super Admin override (optional)
        if (Auth::check() && Auth::user()->is_super_admin && Config::get('tenancy.super_admin_bypass', true)) {
            return $next($request);
        }

        /** @var \App\Models\Subscription|null $subscription */
        $subscription = Subscription::query()
            ->where('company_id', $company->id)
            ->orderByDesc('start_date')
            ->first();

        // No subscription found
        if (! $subscription) {
            return $this->denyAccess($request, 'No active subscription found for this company.');
        }

        // Grace period handling using latest invoice due_date + configured grace days
        $graceDays = (int) Config::get('billing.grace_days', 7);
        $withinGrace = false;

        if ($subscription->relationLoaded('invoices') || method_exists($subscription, 'invoices')) {
            $latestInvoice = $subscription->invoices()
                ->orderByDesc('issue_date')
                ->first();

            if ($latestInvoice && $latestInvoice->due_date) {
                $graceUntil = $latestInvoice->due_date->copy()->addDays($graceDays);
                $withinGrace = now()->lessThanOrEqualTo($graceUntil);
            }
        }

        // Subscription status checks with grace period
        if ($subscription->isCanceled()) {
            return $this->denyAccess($request, 'Subscription is canceled.');
        }

        if ($subscription->isPastDue() && ! $withinGrace) {
            return $this->denyAccess($request, 'Subscription payment is past due and grace period has ended.');
        }

        // Trial or active (or past_due but within grace) check
        if (! $subscription->isOnTrial() && ! $subscription->isActive() && ! $withinGrace) {
            return $this->denyAccess($request, 'Subscription has expired.');
        }

        return $next($request);
    }

    protected function denyAccess(Request $request, string $message): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
            ], 402); // Payment Required
        }

        // Redirect to a billing page route (to be implemented)
        return redirect()
            ->route('billing.subscribe')
            ->withErrors(['subscription' => $message]);
    }
}

