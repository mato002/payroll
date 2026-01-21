<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanySignupRequest;
use App\Models\Company;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompanyOnboardingController extends Controller
{
    /**
     * Show the company signup form.
     */
    public function showForm()
    {
        $plans = SubscriptionPlan::query()
            ->orderBy('base_price')
            ->get(['code', 'name', 'billing_model', 'base_price', 'price_per_employee', 'trial_days', 'currency']);

        return view('auth.company-signup', [
            'plans' => $plans,
        ]);
    }

    /**
     * Handle the company signup submission.
     */
    public function store(CompanySignupRequest $request)
    {
        $data = $request->validated();

        $plan = SubscriptionPlan::where('code', $data['plan_code'])->firstOrFail();

        $company = null;
        $user = null;

        DB::transaction(function () use ($data, $plan, &$company, &$user) {
            // 1. Create admin user
            $user = User::create([
                'name'     => $data['admin_name'],
                'email'    => $data['admin_email'],
                'password' => $data['admin_password'], // hashed by cast
            ]);

            // 2. Create company
            $company = Company::create([
                'name'                => $data['company_name'],
                'legal_name'          => $data['legal_name'] ?? null,
                'registration_number' => $data['registration_number'] ?? null,
                'tax_id'              => $data['tax_id'] ?? null,
                'billing_email'       => $data['billing_email'],
                'country'             => $data['country'] ?? null,
                'timezone'            => $data['timezone'] ?? config('app.timezone'),
                'currency'            => Str::upper($data['currency']),
                'address_line1'       => $data['address_line1'] ?? null,
                'address_line2'       => $data['address_line2'] ?? null,
                'city'                => $data['city'] ?? null,
                'state'               => $data['state'] ?? null,
                'postal_code'         => $data['postal_code'] ?? null,
                'is_active'           => true,
                'subscription_status' => 'trial',
                'trial_ends_at'       => now()->addDays($plan->trial_days),
            ]);

            // 3. Handle logo upload (optional)
            if (! empty($data['logo'])) {
                $path = $data['logo']->store('company-logos', 'public');
                $company->update(['logo_path' => $path]);
            }

            // 4. Attach user to company (company_user pivot)
            $company->members()->attach($user->id, [
                'is_owner'   => true,
                'status'     => 'active',
                'invited_at' => now(),
                'joined_at'  => now(),
            ]);

            // 5. Seed default roles for this company, if they don't exist
            $this->ensureDefaultRolesForCompany($company);

            // 6. Assign company_admin role to user
            $adminRole = Role::where('company_id', $company->id)
                ->where('slug', 'company_admin')
                ->first();

            if ($adminRole) {
                UserRole::create([
                    'company_id' => $company->id,
                    'user_id'    => $user->id,
                    'role_id'    => $adminRole->id,
                ]);
            }

            // 7. Create trial subscription
            Subscription::create([
                'company_id'             => $company->id,
                'external_subscription_id' => null,
                'plan_code'              => $plan->code,
                'billing_cycle'          => 'monthly',
                'status'                 => 'trial',
                'start_date'             => now(),
                'trial_end_date'         => now()->addDays($plan->trial_days),
                'next_billing_date'      => now()->addDays($plan->trial_days),
                'base_price'             => $plan->base_price,
                'per_employee_price'     => $plan->price_per_employee,
                'max_employees_included' => $plan->max_employees,
                'currency'               => $plan->currency,
                'auto_renew'             => true,
            ]);
        });

        // Log in the new admin
        Auth::login($user);

        // Redirect to tenant company admin dashboard on subdomain
        return redirect()->route('company.admin.dashboard', [
            'company' => $company->slug,
        ]);
    }

    /**
     * Ensure default roles exist for a company.
     */
    protected function ensureDefaultRolesForCompany(Company $company): void
    {
        $defaults = [
            ['name' => 'Company Admin', 'slug' => 'company_admin', 'description' => 'Full access to company settings and payroll'],
            ['name' => 'Payroll Officer', 'slug' => 'payroll_officer', 'description' => 'Manage employees and payroll'],
            ['name' => 'Employee', 'slug' => 'employee', 'description' => 'Employee self-service access'],
        ];

        foreach ($defaults as $roleData) {
            Role::firstOrCreate(
                [
                    'company_id' => $company->id,
                    'slug'       => $roleData['slug'],
                ],
                [
                    'name'        => $roleData['name'],
                    'description' => $roleData['description'],
                    'is_system'   => true,
                ],
            );
        }
    }
}

