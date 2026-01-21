# Multi-Tenancy Implementation Guide

This document explains how to use the multi-tenancy system in your Laravel payroll application.

## Overview

The system uses a **single database with `company_id` scoping** to isolate data between companies. All tenant-scoped models automatically filter queries by the current company.

## Key Components

### 1. Company Detection

The system detects the current company using multiple methods (in order):

1. **Subdomain** (e.g., `companyA.app.test`)
2. **HTTP Header** (`X-Company-Slug`)
3. **Session** (`current_company_id`)

### 2. Automatic Query Scoping

All models using the `BelongsToCompany` trait are automatically scoped to the current company.

### 3. Security Features

- Prevents cross-company data access
- Auto-fills `company_id` on creation
- Prevents changing `company_id` after creation (except super admin)
- Validates user access to company

## Configuration

Edit `config/tenancy.php`:

```php
'base_domain' => env('TENANCY_BASE_DOMAIN', 'app.test'),
'detection_methods' => ['subdomain', 'header', 'session'],
'require_company' => false, // Set to true to require company on all routes
'super_admin_bypass' => true, // Allow super admin to bypass scope
```

## Usage Examples

### Basic Model Usage

```php
use App\Models\Employee;

// Automatically scoped to current company
$employees = Employee::all();

// Create employee (company_id auto-filled)
$employee = Employee::create([
    'employee_code' => 'EMP001',
    'first_name' => 'John',
    'last_name' => 'Doe',
    // company_id is automatically set
]);

// Query is still scoped
$activeEmployees = Employee::where('is_active', true)->get();
```

### Using Helper Functions

```php
use function App\Helpers\currentCompany;
use function App\Helpers\currentCompanyId;
use function App\Helpers\hasCompany;

// Get current company instance
$company = currentCompany();

// Get current company ID
$companyId = currentCompanyId();

// Check if company is set
if (hasCompany()) {
    // Do something
}
```

### Routes Setup

#### Subdomain-based Routes

```php
// routes/web.php
Route::domain('{company}.' . config('tenancy.base_domain'))
    ->middleware(['web', 'tenant', 'auth'])
    ->group(function () {
        Route::get('/employees', [EmployeeController::class, 'index']);
        Route::get('/payslips', [PayslipController::class, 'index']);
    });
```

#### Public Routes (No Company Required)

```php
Route::get('/', function () {
    return view('welcome');
});
```

#### Super Admin Routes

```php
Route::middleware(['web', 'auth', 'role:super_admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/companies', [CompanyController::class, 'index']);
    });
```

### Bypassing Company Scope (Super Admin Only)

```php
use App\Models\Employee;

// WARNING: Only use if user is super admin!
if (Auth::user()->is_super_admin) {
    // Get all employees across all companies
    $allEmployees = Employee::withoutCompanyScope()->get();
    
    // Query specific company
    $companyEmployees = Employee::withoutCompanyScope()
        ->where('company_id', $companyId)
        ->get();
}
```

### Checking Company Access

```php
$employee = Employee::findOrFail($employeeId);

// Check if employee belongs to current company
if (!$employee->belongsToCurrentCompany()) {
    abort(403, 'Access denied');
}
```

### Middleware Usage

The `SetCurrentCompany` middleware automatically:
- Detects company from subdomain/header/session
- Sets current company in container
- Validates user access to company
- Shares company with views

Apply it to tenant routes:

```php
Route::middleware(['web', 'tenant', 'auth'])->group(function () {
    // Tenant-scoped routes
});
```

## Model Setup

To make a model tenant-scoped, use the `BelongsToCompany` trait:

```php
use App\Models\Traits\BelongsToCompany;

class MyModel extends Model
{
    use BelongsToCompany;
    
    protected $fillable = [
        'company_id',
        // other fields
    ];
}
```

## Security Best Practices

1. **Always use the trait** on tenant-scoped models
2. **Never bypass scope** unless absolutely necessary (super admin only)
3. **Validate access** before showing sensitive data
4. **Use policies** to enforce additional access rules
5. **Test cross-company access** to ensure isolation

## Testing

```php
// In tests, set a company context
$company = Company::factory()->create(['slug' => 'test-company']);
setCompany($company);

// Now all queries are scoped to this company
$employees = Employee::factory()->count(5)->create();
// All employees have company_id = $company->id
```

## Troubleshooting

### Issue: Queries return empty results

**Solution**: Ensure company is detected and set. Check:
- Subdomain is correct
- Company exists with matching slug
- Middleware is applied to route

### Issue: Cannot create records

**Solution**: Ensure `company_id` is in `$fillable` and company is detected.

### Issue: Super admin cannot see all data

**Solution**: Check `config('tenancy.super_admin_bypass')` is `true`.

## Environment Variables

Add to `.env`:

```env
TENANCY_BASE_DOMAIN=app.test
TENANCY_HEADER_NAME=X-Company-Slug
TENANCY_SESSION_KEY=current_company_id
TENANCY_REQUIRE_COMPANY=false
TENANCY_SUPER_ADMIN_BYPASS=true
```
