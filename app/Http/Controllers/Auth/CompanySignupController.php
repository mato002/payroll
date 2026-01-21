<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CompanySignupRequest;
use App\Models\Company;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompanySignupController extends Controller
{
    /**
     * Show the company signup form.
     */
    public function create()
    {
        return view('auth.company-signup');
    }

    /**
     * Handle company signup and initial onboarding.
     */
    public function store(CompanySignupRequest $request)
    {
        $data = $request->validated();

        $defaultPlanCode = config('billing.default_plan_code', 'starter');

        DB::beginTransaction();

        try {
            // 1. Create company
            $company = Company::create([
                'name'          => $data['company_name'],
                'slug'          => Str::slug($data['company_name']),
                'billing_email' => $data['admin_email'],
                'country'       => $data['country'] ?? null,
                'currency'      => $data['currency'] ?? 'USD',
                'subscription_status' => 'trial',
                'trial_ends_at'       => null, // set after subscription
            ]);

            // 2. Create admin user
            $user = User::create([
                'name'     => $data['admin_name'],
                'email'    => $data['admin_email'],
                'password' => $data['password'],
            ]);

            // Link user to company as owner
            $company->members()->attach($user->id, [
                'is_owner'   => true,
                'status'     => 'active',
                'invited_at' => now(),
                'joined_at'  => now(),
            ]);

            // 3. Ensure default roles exist and assign Company Admin role
            $companyAdminRole = Role::firstOrCreate(
                ['company_id' => $company->id, 'slug' => 'company_admin'],
                ['name' => 'Company Admin', 'description' => 'Company administrator', 'is_system' => true]
            );

            UserRole::create([
                'company_id' => $company->id,
                'user_id'    => $user->id,
                'role_id'    => $companyAdminRole->id,
            ]);

            // 4. Create trial subscription
            $plan = SubscriptionPlan::where('code', $defaultPlanCode)->first();
            $trialDays = $plan?->trial_days ?? 14;
            $trialEndsAt = now()->addDays($trialDays);

            Subscription::create([
                'company_id'             => $company->id,
                'external_subscription_id' => null,
                'plan_code'              => $plan?->code ?? $defaultPlanCode,
                'billing_cycle'          => 'monthly',
                'status'                 => 'trial',
                'start_date'             => now(),
                'end_date'               => null,
                'trial_end_date'         => $trialEndsAt,
                'next_billing_date'      => now()->addMonth(),
                'base_price'             => $plan?->base_price ?? 0,
                'per_employee_price'     => $plan?->price_per_employee,
                'max_employees_included' => $plan?->max_employees,
                'currency'               => $plan?->currency ?? 'USD',
                'auto_renew'             => true,
            ]);

            $company->update([
                'trial_ends_at'        => $trialEndsAt,
                'subscription_status'  => 'trial',
            ]);

            DB::commit();

            // Log in the new admin
            Auth::login($user);

            // Redirect to company profile onboarding (tenant subdomain or path)
            return redirect()->route('onboarding.company.profile.edit', [
                'company' => $company->slug,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return back()
                ->withInput()
                ->withErrors(['signup' => 'Unable to complete signup. Please try again.']);
        }
    }
}

