<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetCurrentCompany;
use App\Http\Controllers\Auth\CompanyOnboardingController;
use App\Http\Controllers\Payroll\PayrollRunWorkflowController;
use App\Http\Controllers\Admin\SuperAdminDashboardController;
use App\Http\Controllers\Payroll\PayrollRunWizardController;

/*
|--------------------------------------------------------------------------
| Public / Landing Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'landing')->name('landing');
Route::view('/pricing', 'pricing')->name('pricing');
Route::view('/features', 'features')->name('features');
Route::view('/contact', 'contact')->name('contact');

Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'submit'])
    ->name('contact.submit');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'create'])
        ->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'store'])
        ->name('login.store');
    
    Route::get('/forgot-password', function () {
        return view('auth.passwords.email');
    })->name('password.request');
    
    Route::post('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])
        ->name('password.email');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'destroy'])
        ->name('logout');
});

// Company signup (public) - uses onboarding controller with plans
Route::get('/signup', [CompanyOnboardingController::class, 'showForm'])
    ->name('company.signup');

Route::post('/signup', [CompanyOnboardingController::class, 'store'])
    ->name('company.signup.store');

/*
|--------------------------------------------------------------------------
| Super Admin (Platform Owner) Routes
|--------------------------------------------------------------------------
|
| These routes are not tenant-scoped and are intended for managing companies,
| plans, and subscriptions at the platform level.
|
*/

Route::middleware(['web', 'auth', 'role:super_admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])
            ->name('admin.dashboard');
    });

/*
|--------------------------------------------------------------------------
| Company Switching Routes
|--------------------------------------------------------------------------
|
| Allow authenticated users to switch between companies they belong to.
| These routes work without subdomain requirement.
|
*/

Route::middleware(['web', 'auth'])
    ->prefix('companies')
    ->name('companies.')
    ->group(function () {
        Route::get('/switch', [\App\Http\Controllers\CompanySwitchController::class, 'index'])
            ->name('switch.index');
        
        Route::post('/switch/{company}', [\App\Http\Controllers\CompanySwitchController::class, 'switch'])
            ->name('switch.store');
        
        Route::post('/clear', [\App\Http\Controllers\CompanySwitchController::class, 'clear'])
            ->name('switch.clear');
        
        Route::get('/list', [\App\Http\Controllers\CompanySwitchController::class, 'list'])
            ->name('list'); // JSON endpoint for AJAX
    });

/*
|--------------------------------------------------------------------------
| Tenant (Company) Routes
|--------------------------------------------------------------------------
|
| These routes are scoped to a specific company resolved from the subdomain.
| Within the tenant, role-based access control further restricts access to
| company admins (HR) and employees.
|
*/

// Example tenant routes using subdomains like "acme.app.test"
Route::domain('{company}.' . config('tenancy.base_domain'))
    ->middleware(['web', SetCurrentCompany::class, 'auth', 'subscribed'])
    ->group(function () {
        // Onboarding: company profile setup
        Route::middleware(['role:company_admin'])
            ->prefix('onboarding')
            ->group(function () {
                Route::get('/company-profile', [\App\Http\Controllers\Onboarding\CompanyProfileController::class, 'edit'])
                    ->name('onboarding.company.profile.edit');
                Route::post('/company-profile', [\App\Http\Controllers\Onboarding\CompanyProfileController::class, 'update'])
                    ->name('onboarding.company.profile.update');
            });
        // Company Admin (HR) area
        Route::middleware(['role:company_admin'])
            ->prefix('admin')
            ->group(function () {
                Route::get('/dashboard', \App\Http\Controllers\Company\AdminDashboardController::class)
                    ->name('company.admin.dashboard');

                // Payroll run wizard
                Route::get('/payroll-runs/wizard', [PayrollRunWizardController::class, 'create'])
                    ->name('payroll.runs.wizard.create');
                Route::post('/payroll-runs/wizard', [PayrollRunWizardController::class, 'storeStep'])
                    ->name('payroll.runs.wizard.store');

                // Compliance Reports
                Route::prefix('reports')
                    ->name('reports.')
                    ->group(function () {
                        Route::get('/', function () {
                            return view('reports.index');
                        })->name('index');

                        // Tax Summary Report
                        Route::get('/tax', [\App\Http\Controllers\Reports\TaxReportController::class, 'index'])
                            ->name('tax.index');
                        Route::post('/tax/generate', [\App\Http\Controllers\Reports\TaxReportController::class, 'generate'])
                            ->name('tax.generate');

                        // Pension/NSSF Report
                        Route::get('/pension', [\App\Http\Controllers\Reports\PensionReportController::class, 'index'])
                            ->name('pension.index');
                        Route::post('/pension/generate', [\App\Http\Controllers\Reports\PensionReportController::class, 'generate'])
                            ->name('pension.generate');

                        // Annual Payroll Summary Report
                        Route::get('/annual', [\App\Http\Controllers\Reports\AnnualPayrollReportController::class, 'index'])
                            ->name('annual.index');
                        Route::post('/annual/generate', [\App\Http\Controllers\Reports\AnnualPayrollReportController::class, 'generate'])
                            ->name('annual.generate');
                    });

                // Payroll workflow routes
                Route::post('/payroll-runs/{run}/submit-review', [PayrollRunWorkflowController::class, 'submitForReview'])
                    ->name('payroll.runs.submit_review');
                Route::post('/payroll-runs/{run}/approve', [PayrollRunWorkflowController::class, 'approve'])
                    ->name('payroll.runs.approve');
                Route::post('/payroll-runs/{run}/close', [PayrollRunWorkflowController::class, 'close'])
                    ->name('payroll.runs.close');

                // Employee management routes
                Route::prefix('employees')
                    ->name('employees.')
                    ->group(function () {
                        Route::get('/', [\App\Http\Controllers\Employee\EmployeeController::class, 'index'])
                            ->name('index');
                        Route::get('/create', [\App\Http\Controllers\Employee\EmployeeController::class, 'create'])
                            ->name('create');
                        Route::post('/', [\App\Http\Controllers\Employee\EmployeeController::class, 'store'])
                            ->name('store');
                        Route::get('/{employee}', [\App\Http\Controllers\Employee\EmployeeController::class, 'show'])
                            ->name('show');
                        Route::get('/{employee}/edit', [\App\Http\Controllers\Employee\EmployeeController::class, 'edit'])
                            ->name('edit');
                        Route::put('/{employee}', [\App\Http\Controllers\Employee\EmployeeController::class, 'update'])
                            ->name('update');
                        Route::delete('/{employee}', [\App\Http\Controllers\Employee\EmployeeController::class, 'destroy'])
                            ->name('destroy');
                        Route::get('/{employee}/get', [\App\Http\Controllers\Employee\EmployeeController::class, 'get'])
                            ->name('get');

                        // Import routes
                        Route::get('/import', [\App\Http\Controllers\Employee\EmployeeImportController::class, 'create'])
                            ->name('import.create');
                        Route::post('/import', [\App\Http\Controllers\Employee\EmployeeImportController::class, 'store'])
                            ->name('import.store');
                        Route::get('/import/template', [\App\Http\Controllers\Employee\EmployeeImportController::class, 'downloadTemplate'])
                            ->name('import.template');

                        // Export routes
                        Route::get('/export', [\App\Http\Controllers\Employee\EmployeeExportController::class, 'export'])
                            ->name('export');
                    });
            });

        // Employee self-service area (payslips only)
        Route::middleware(['role:employee'])
            ->prefix('employee')
            ->group(function () {
                Route::get('/payslips', [\App\Http\Controllers\PayslipController::class, 'index'])
                    ->name('employee.payslips.index');

                Route::get('/payslips/{payslip}/download', [\App\Http\Controllers\PayslipController::class, 'download'])
                    ->name('employee.payslips.download');
            });
    });
