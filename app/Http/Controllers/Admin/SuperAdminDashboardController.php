<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Subscription;
use App\Models\Invoice;
use Carbon\Carbon;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        // Summary metrics
        $totalCompanies      = Company::count();
        $activeCompanies     = Company::where('is_active', true)->count();
        $activeSubscriptions = Subscription::where('status', 'active')->count();
        $trialSubscriptions  = Subscription::where('status', 'trial')->count();

        // Simple MRR approximation (sum of base_price for active/trial subs)
        $mrr = Subscription::whereIn('status', ['active', 'trial'])->sum('base_price');

        // Revenue this month
        $startOfMonth = now()->startOfMonth();
        $endOfMonth   = now()->endOfMonth();

        $monthlyRevenue = Invoice::whereBetween('issue_date', [$startOfMonth, $endOfMonth])
            ->whereIn('status', ['paid', 'partially_paid'])
            ->sum('total_amount');

        // Companies table data with latest subscription
        $companies = Company::query()
            ->with(['subscriptions' => function ($q) {
                $q->latest('start_date')->limit(1);
            }])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(function (Company $company) {
                $sub = $company->subscriptions->first();

                return [
                    'id'          => $company->id,
                    'name'        => $company->name,
                    'created_at'  => $company->created_at,
                    'status'      => $company->subscription_status,
                    'is_active'   => $company->is_active,
                    'plan_code'   => $sub?->plan_code,
                    'sub_status'  => $sub?->status,
                    'next_billing'=> $sub?->next_billing_date,
                ];
            });

        return view('admin.dashboard', [
            'summary' => [
                'total_companies'       => $totalCompanies,
                'active_companies'      => $activeCompanies,
                'active_subscriptions'  => $activeSubscriptions,
                'trial_subscriptions'   => $trialSubscriptions,
                'mrr'                   => $mrr,
                'monthly_revenue'       => $monthlyRevenue,
            ],
            'companies' => $companies,
        ]);
    }
}

