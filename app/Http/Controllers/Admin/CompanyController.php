<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanySignupRequest;
use App\Models\Company;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * List all companies.
     */
    public function index()
    {
        $companies = Company::with(['subscriptions.plan'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.companies.index', [
            'companies' => $companies,
        ]);
    }

    /**
     * Show a single company's details.
     */
    public function show(Company $company)
    {
        $company->load(['subscriptions.plan', 'members']);

        return view('admin.companies.show', [
            'company' => $company,
        ]);
    }

    /**
     * Show the company creation form for admin.
     */
    public function create()
    {
        $plans = SubscriptionPlan::query()
            ->orderBy('base_price')
            ->get(['code', 'name', 'billing_model', 'base_price', 'price_per_employee', 'trial_days', 'currency']);

        return view('admin.companies.create', [
            'plans' => $plans,
        ]);
    }

    /**
     * Store a new company (admin-created).
     */
    public function store(CompanySignupRequest $request)
    {
        $data = $request->validated();
        $plan = SubscriptionPlan::where('code', $data['plan_code'])->firstOrFail();

        $company = null;
        $user = null;

        DB::transaction(function () use ($data, $plan, &$company, &$user) {
            // 1. Create or get admin user
            $user = User::firstOrCreate(
                ['email' => $data['admin_email']],
                [
                    'name'     => $data['admin_name'],
                    'password' => $data['admin_password'], // hashed by cast
                ]
            );

            // If user exists, update name and password
            if ($user->wasRecentlyCreated === false) {
                $user->update([
                    'name'     => $data['admin_name'],
                    'password' => $data['admin_password'],
                ]);
            }

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
            $company->members()->syncWithoutDetaching([$user->id => [
                'is_owner'   => true,
                'status'     => 'active',
                'invited_at' => now(),
                'joined_at'  => now(),
            ]]);

            // 5. Seed default roles for this company
            $this->ensureDefaultRolesForCompany($company);

            // 6. Assign company_admin role to user
            $adminRole = Role::where('company_id', $company->id)
                ->where('slug', 'company_admin')
                ->first();

            if ($adminRole) {
                UserRole::updateOrCreate(
                    [
                        'company_id' => $company->id,
                        'user_id'    => $user->id,
                    ],
                    ['role_id' => $adminRole->id]
                );
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

        return redirect()->route('admin.dashboard')
            ->with('success', "Company '{$company->name}' created successfully.");
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
