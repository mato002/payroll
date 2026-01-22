<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetCurrentCompany;
use App\Http\Middleware\EnsureCompanyIsSubscribed;
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
Route::view('/security', 'security')->name('security');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');

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
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])
            ->name('dashboard');
        
        // Company management
        Route::prefix('companies')
            ->name('companies.')
            ->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\CompanyController::class, 'index'])
                    ->name('index');
                Route::get('/create', [\App\Http\Controllers\Admin\CompanyController::class, 'create'])
                    ->name('create');
                Route::post('/', [\App\Http\Controllers\Admin\CompanyController::class, 'store'])
                    ->name('store');
            });
        
        // Subscription Plans
        Route::get('/subscription-plans', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'index'])
            ->name('subscription-plans.index');
        
        // Users
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])
            ->name('users.index');
        
        // Settings
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])
            ->name('settings.index');
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
        
        // Path-based company routes (alternative to subdomain)
        Route::middleware([SetCurrentCompany::class, EnsureCompanyIsSubscribed::class])
            ->prefix('{company}')
            ->group(function () {
                Route::middleware(['role:company_admin'])
                    ->prefix('admin')
                    ->group(function () {
                        Route::get('/dashboard', \App\Http\Controllers\Company\AdminDashboardController::class)
                            ->name('company.admin.dashboard.path');

                        // Payroll runs (path-based)
                        Route::prefix('payroll-runs')
                            ->name('payroll.runs.path.')
                            ->group(function () {
                                Route::get('/', [\App\Http\Controllers\Payroll\PayrollRunController::class, 'index'])
                                    ->name('index');
                                Route::get('/wizard', [PayrollRunWizardController::class, 'create'])
                                    ->name('wizard.create');
                                Route::post('/wizard', [PayrollRunWizardController::class, 'storeStep'])
                                    ->name('wizard.store');
                                Route::get('/{run}/review', [\App\Http\Controllers\Payroll\PayrollRunWorkflowController::class, 'show'])
                                    ->name('review');
                                Route::post('/{run}/approve', [\App\Http\Controllers\Payroll\PayrollRunWorkflowController::class, 'approve'])
                                    ->name('approve');
                                Route::post('/{run}/reject', [\App\Http\Controllers\Payroll\PayrollRunWorkflowController::class, 'reject'])
                                    ->name('reject');
                                Route::post('/{run}/submit-review', [\App\Http\Controllers\Payroll\PayrollRunWorkflowController::class, 'submitForReview'])
                                    ->name('submit_review');
                                Route::post('/{run}/close', [\App\Http\Controllers\Payroll\PayrollRunWorkflowController::class, 'close'])
                                    ->name('close');
                            });

                        // Employees
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
                                Route::get('/import', [\App\Http\Controllers\Employee\EmployeeImportController::class, 'create'])
                                    ->name('import.create');
                                Route::post('/import', [\App\Http\Controllers\Employee\EmployeeImportController::class, 'store'])
                                    ->name('import.store');
                                Route::get('/import/template', [\App\Http\Controllers\Employee\EmployeeImportController::class, 'downloadTemplate'])
                                    ->name('import.template');
                                Route::get('/export', [\App\Http\Controllers\Employee\EmployeeExportController::class, 'export'])
                                    ->name('export');
                            });

                        // Salary Structures
                        Route::prefix('salary-structures')
                            ->name('salary-structures.')
                            ->group(function () {
                                Route::get('/', [\App\Http\Controllers\SalaryStructureController::class, 'index'])
                                    ->name('index');
                                Route::get('/create', [\App\Http\Controllers\SalaryStructureController::class, 'create'])
                                    ->name('create');
                                Route::post('/', [\App\Http\Controllers\SalaryStructureController::class, 'store'])
                                    ->name('store');
                                Route::get('/{salaryStructure}', [\App\Http\Controllers\SalaryStructureController::class, 'show'])
                                    ->name('show');
                                Route::get('/{salaryStructure}/edit', [\App\Http\Controllers\SalaryStructureController::class, 'edit'])
                                    ->name('edit');
                                Route::put('/{salaryStructure}', [\App\Http\Controllers\SalaryStructureController::class, 'update'])
                                    ->name('update');
                                Route::delete('/{salaryStructure}', [\App\Http\Controllers\SalaryStructureController::class, 'destroy'])
                                    ->name('destroy');
                            });

                        // Settings
                        Route::prefix('settings')
                            ->name('settings.')
                            ->group(function () {
                                Route::get('/', [\App\Http\Controllers\Company\SettingsController::class, 'index'])
                                    ->name('index');
                                Route::put('/', [\App\Http\Controllers\Company\SettingsController::class, 'update'])
                                    ->name('update');
                            });
                    });

                // Employee routes
                Route::middleware(['role:employee'])
                    ->prefix('employee')
                    ->name('employee.')
                    ->group(function () {
                        Route::get('/dashboard', [\App\Http\Controllers\Employee\EmployeeDashboardController::class, 'index'])
                            ->name('dashboard');
                        Route::get('/payslips', [\App\Http\Controllers\PayslipController::class, 'index'])
                            ->name('payslips.index');
                        Route::get('/payslips/{payslip}/download', [\App\Http\Controllers\PayslipController::class, 'download'])
                            ->name('payslips.download');
                        Route::get('/profile', [\App\Http\Controllers\Employee\EmployeeProfileController::class, 'show'])
                            ->name('profile.show');
                        Route::put('/profile', [\App\Http\Controllers\Employee\EmployeeProfileController::class, 'update'])
                            ->name('profile.update');
                        Route::get('/notifications', [\App\Http\Controllers\Employee\EmployeeNotificationsController::class, 'index'])
                            ->name('notifications.index');
                        Route::post('/notifications/{id}/read', [\App\Http\Controllers\Employee\EmployeeNotificationsController::class, 'markAsRead'])
                            ->name('notifications.read');
                        Route::post('/notifications/read-all', [\App\Http\Controllers\Employee\EmployeeNotificationsController::class, 'markAllAsRead'])
                            ->name('notifications.read-all');
                        Route::get('/help', [\App\Http\Controllers\Employee\EmployeeHelpController::class, 'index'])
                            ->name('help.index');
                    });
            });
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

/*
// Example tenant routes using subdomains like "acme.app.test"
// DISABLED: Using path-based routing instead
Route::domain('{company}.' . config('tenancy.base_domain'))
    ->middleware(['web', SetCurrentCompany::class, 'auth', EnsureCompanyIsSubscribed::class])
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

                // Payroll runs
                Route::prefix('payroll-runs')
                    ->name('payroll.runs.')
                    ->group(function () {
                        Route::get('/', [\App\Http\Controllers\Payroll\PayrollRunController::class, 'index'])
                            ->name('index');
                        Route::get('/wizard', [PayrollRunWizardController::class, 'create'])
                            ->name('wizard.create');
                        Route::post('/wizard', [PayrollRunWizardController::class, 'storeStep'])
                            ->name('wizard.store');
                    });

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
                Route::get('/payroll-runs/{run}/review', [PayrollRunWorkflowController::class, 'show'])
                    ->name('payroll.runs.review');
                Route::post('/payroll-runs/{run}/submit-review', [PayrollRunWorkflowController::class, 'submitForReview'])
                    ->name('payroll.runs.submit_review');
                Route::post('/payroll-runs/{run}/approve', [PayrollRunWorkflowController::class, 'approve'])
                    ->name('payroll.runs.approve');
                Route::post('/payroll-runs/{run}/reject', [PayrollRunWorkflowController::class, 'reject'])
                    ->name('payroll.runs.reject');
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

                // Export status check (for async exports)
                Route::get('/exports/{jobId}/status', [\App\Http\Controllers\ExportStatusController::class, 'status'])
                    ->name('exports.status');

                // Salary Structure management routes
                Route::prefix('salary-structures')
                    ->name('salary-structures.')
                    ->group(function () {
                        Route::get('/', [\App\Http\Controllers\SalaryStructureController::class, 'index'])
                            ->name('index');
                        Route::get('/create', [\App\Http\Controllers\SalaryStructureController::class, 'create'])
                            ->name('create');
                        Route::post('/', [\App\Http\Controllers\SalaryStructureController::class, 'store'])
                            ->name('store');
                        Route::get('/{salaryStructure}', [\App\Http\Controllers\SalaryStructureController::class, 'show'])
                            ->name('show');
                        Route::get('/{salaryStructure}/edit', [\App\Http\Controllers\SalaryStructureController::class, 'edit'])
                            ->name('edit');
                        Route::put('/{salaryStructure}', [\App\Http\Controllers\SalaryStructureController::class, 'update'])
                            ->name('update');
                        Route::delete('/{salaryStructure}', [\App\Http\Controllers\SalaryStructureController::class, 'destroy'])
                            ->name('destroy');
                    });

                // Subscription management routes
                Route::prefix('subscriptions')
                    ->name('subscriptions.')
                    ->group(function () {
                        Route::get('/', [\App\Http\Controllers\SubscriptionController::class, 'index'])
                            ->name('index');
                        Route::get('/change-plan/{plan}', [\App\Http\Controllers\SubscriptionController::class, 'showChangePlan'])
                            ->name('change-plan.show');
                        Route::post('/change-plan/{plan}', [\App\Http\Controllers\SubscriptionController::class, 'changePlan'])
                            ->name('change-plan.store');
                        Route::post('/cancel', [\App\Http\Controllers\SubscriptionController::class, 'cancel'])
                            ->name('cancel');
                        Route::prefix('invoices')
                            ->name('invoices.')
                            ->group(function () {
                                Route::get('/{invoice}/download', [\App\Http\Controllers\SubscriptionController::class, 'downloadInvoice'])
                                    ->name('download');
                            });
                    });

                // Payslips management (admin view)
                Route::prefix('payslips')
                    ->name('payslips.')
                    ->group(function () {
                        Route::get('/', [\App\Http\Controllers\PayslipController::class, 'adminIndex'])
                            ->name('index');
                        Route::get('/{payslip}/download', [\App\Http\Controllers\PayslipController::class, 'download'])
                            ->name('download');
                    });

                // Tax & Compliance
                Route::get('/tax-compliance', [\App\Http\Controllers\Reports\TaxReportController::class, 'index'])
                    ->name('tax-compliance.index');

                // Users & Roles management
                Route::prefix('users-roles')
                    ->name('users-roles.')
                    ->group(function () {
                        Route::get('/', [\App\Http\Controllers\Company\UserRoleController::class, 'index'])
                            ->name('index');
                        Route::get('/create', [\App\Http\Controllers\Company\UserRoleController::class, 'create'])
                            ->name('create');
                        Route::post('/', [\App\Http\Controllers\Company\UserRoleController::class, 'store'])
                            ->name('store');
                        Route::get('/{user}/edit', [\App\Http\Controllers\Company\UserRoleController::class, 'edit'])
                            ->name('edit');
                        Route::put('/{user}', [\App\Http\Controllers\Company\UserRoleController::class, 'update'])
                            ->name('update');
                    });

                // Company Settings
                Route::prefix('settings')
                    ->name('settings.')
                    ->group(function () {
                        Route::get('/', [\App\Http\Controllers\Company\SettingsController::class, 'index'])
                            ->name('index');
                        Route::put('/', [\App\Http\Controllers\Company\SettingsController::class, 'update'])
                            ->name('update');
                    });
            });

        // Employee self-service area
        Route::middleware(['role:employee'])
            ->prefix('employee')
            ->name('employee.')
            ->group(function () {
                // Dashboard
                Route::get('/dashboard', [\App\Http\Controllers\Employee\EmployeeDashboardController::class, 'index'])
                    ->name('dashboard');

                // Payslips
                Route::get('/payslips', [\App\Http\Controllers\PayslipController::class, 'index'])
                    ->name('payslips.index');

                Route::get('/payslips/{payslip}/download', [\App\Http\Controllers\PayslipController::class, 'download'])
                    ->name('payslips.download');

                // Profile
                Route::get('/profile', [\App\Http\Controllers\Employee\EmployeeProfileController::class, 'show'])
                    ->name('profile.show');

                Route::put('/profile', [\App\Http\Controllers\Employee\EmployeeProfileController::class, 'update'])
                    ->name('profile.update');

                // Notifications
                Route::get('/notifications', [\App\Http\Controllers\Employee\EmployeeNotificationsController::class, 'index'])
                    ->name('notifications.index');

                Route::post('/notifications/{id}/read', [\App\Http\Controllers\Employee\EmployeeNotificationsController::class, 'markAsRead'])
                    ->name('notifications.read');

                Route::post('/notifications/read-all', [\App\Http\Controllers\Employee\EmployeeNotificationsController::class, 'markAllAsRead'])
                    ->name('notifications.read-all');

                // Help / Support
                Route::get('/help', [\App\Http\Controllers\Employee\EmployeeHelpController::class, 'index'])
                    ->name('help.index');
            });
    });
*/
