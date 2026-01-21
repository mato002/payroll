<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Employee;
use App\Models\PayrollRun;
use App\Models\Payslip;
use App\Models\Subscription;
use App\Policies\CompanyPolicy;
use App\Policies\EmployeePolicy;
use App\Policies\PayrollRunPolicy;
use App\Policies\PayslipPolicy;
use App\Policies\SubscriptionPolicy;
use App\Support\ExchangeRateService;
use App\Tenancy\CurrentCompany;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Company::class      => CompanyPolicy::class,
        Employee::class     => EmployeePolicy::class,
        PayrollRun::class   => PayrollRunPolicy::class,
        Payslip::class      => PayslipPolicy::class,
        Subscription::class => SubscriptionPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CurrentCompany::class, function () {
            return new CurrentCompany();
        });

        $this->app->singleton(ExchangeRateService::class, function ($app) {
            return new ExchangeRateService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}

