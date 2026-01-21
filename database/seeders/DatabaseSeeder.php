<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Role;
use App\Models\UserRole;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * Super admin account for accessing the platform dashboard
         * -------------------------------------------------------
         * Email:    superadmin@example.com
         * Password: password
         */
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name'           => 'Super Admin',
                'password'       => 'password', // hashed by User::casts()
                'is_super_admin' => true,
            ]
        );

        /**
         * Sample tenant company + users
         * -----------------------------
         * Company admin:
         *   Email:    companyadmin@example.com
         *   Password: password
         *
         * Employee:
         *   Email:    employee@example.com
         *   Password: password
         */

        // Ensure there is at least one subscription plan
        $plan = SubscriptionPlan::first() ?? SubscriptionPlan::create([
            'code'               => 'starter',
            'name'               => 'Starter',
            'billing_model'      => 'per_employee',
            'base_price'         => 0,
            'price_per_employee' => 0,
            'min_employees'      => 1,
            'max_employees'      => 50,
            'trial_days'         => 14,
            'currency'           => 'USD',
            'features'           => [],
        ]);

        // Company
        $company = Company::updateOrCreate(
            ['name' => 'Acme Corp'],
            [
                'slug'                => Str::slug('Acme Corp'),
                'billing_email'       => 'companyadmin@example.com',
                'country'             => 'US',
                'timezone'            => config('app.timezone'),
                'currency'            => 'USD',
                'is_active'           => true,
                'subscription_status' => 'trial',
                'trial_ends_at'       => now()->addDays($plan->trial_days),
            ]
        );

        // Company admin user
        $companyAdmin = User::updateOrCreate(
            ['email' => 'companyadmin@example.com'],
            [
                'name'     => 'Company Admin',
                'password' => 'password',
            ]
        );

        // Attach admin to company (pivot)
        $company->members()->syncWithoutDetaching([
            $companyAdmin->id => [
                'is_owner'   => true,
                'status'     => 'active',
                'invited_at' => now(),
                'joined_at'  => now(),
            ],
        ]);

        // Create default roles for this company
        $companyAdminRole = Role::updateOrCreate(
            ['company_id' => $company->id, 'slug' => 'company_admin'],
            [
                'name'        => 'Company Admin',
                'description' => 'Company administrator',
                'is_system'   => true,
            ]
        );

        $employeeRole = Role::updateOrCreate(
            ['company_id' => $company->id, 'slug' => 'employee'],
            [
                'name'        => 'Employee',
                'description' => 'Employee self-service access',
                'is_system'   => true,
            ]
        );

        // Link roles
        UserRole::updateOrCreate(
            [
                'company_id' => $company->id,
                'user_id'    => $companyAdmin->id,
                'role_id'    => $companyAdminRole->id,
            ],
            []
        );

        // Create a subscription record
        Subscription::updateOrCreate(
            [
                'company_id' => $company->id,
                'plan_code'  => $plan->code,
            ],
            [
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
            ]
        );

        // Employee user (self-service)
        $employeeUser = User::updateOrCreate(
            ['email' => 'employee@example.com'],
            [
                'name'     => 'Sample Employee',
                'password' => 'password',
            ]
        );

        // Attach employee to company and role
        $company->members()->syncWithoutDetaching([
            $employeeUser->id => [
                'is_owner'   => false,
                'status'     => 'active',
                'invited_at' => now(),
                'joined_at'  => now(),
            ],
        ]);

        UserRole::updateOrCreate(
            [
                'company_id' => $company->id,
                'user_id'    => $employeeUser->id,
                'role_id'    => $employeeRole->id,
            ],
            []
        );
    }
}

