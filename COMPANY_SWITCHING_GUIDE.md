# Company Switching Implementation Guide

This guide explains how company switching works for users who belong to multiple companies in the payroll SaaS system.

## Overview

Users can belong to multiple companies and switch between them without logging out. The selected company is persisted in the session and automatically detected on subsequent requests.

## Features

- ✅ Switch between companies without re-login
- ✅ Session-based persistence
- ✅ Secure access checks (users can only switch to companies they belong to)
- ✅ Audit logging for company switches
- ✅ Works with subdomain-based routing
- ✅ UI components for easy switching

---

## Implementation Details

### 1. Controller: `CompanySwitchController`

Located at: `app/Http/Controllers/CompanySwitchController.php`

**Methods:**

- `index()` - Show company switcher interface
- `switch(Company $company)` - Switch to a specific company
- `clear()` - Clear company context
- `list()` - JSON endpoint for AJAX requests

### 2. Middleware Updates

**`SetCurrentCompany` middleware** has been updated to:

1. **Prioritize session** for authenticated users when no subdomain is present
2. **Fall back to subdomain** if session company is not accessible
3. **Verify access** before setting company from session

### 3. Routes

```php
// Company switching routes (no subdomain required)
Route::middleware(['web', 'auth'])
    ->prefix('companies')
    ->name('companies.')
    ->group(function () {
        Route::get('/switch', [CompanySwitchController::class, 'index'])
            ->name('switch.index');
        
        Route::post('/switch/{company}', [CompanySwitchController::class, 'switch'])
            ->name('switch.store');
        
        Route::post('/clear', [CompanySwitchController::class, 'clear'])
            ->name('switch.clear');
        
        Route::get('/list', [CompanySwitchController::class, 'list'])
            ->name('list'); // JSON endpoint
    });
```

### 4. User Model Helper

Added `accessibleCompanies()` method to `User` model:

```php
$companies = $user->accessibleCompanies();
```

Returns all companies the user can access (active membership, active company).

---

## Usage Examples

### Basic Company Switching

```php
// In a controller or route
use App\Http\Controllers\CompanySwitchController;

// Switch to a company
Route::post('/companies/switch/{company}', [CompanySwitchController::class, 'switch']);

// User visits: POST /companies/switch/123
// Company ID 123 is stored in session
// User is redirected to dashboard
```

### Programmatic Company Switching

```php
use App\Models\Company;
use Illuminate\Support\Facades\Session;
use App\Tenancy\CurrentCompany;

$company = Company::find($companyId);
$user = Auth::user();

// Verify access
if ($user->companies()->where('companies.id', $company->id)->exists()) {
    // Store in session
    Session::put('current_company_id', $company->id);
    
    // Update container
    app(CurrentCompany::class)->set($company);
}
```

### Getting Current Company

```php
use App\Tenancy\CurrentCompany;

$currentCompany = app(CurrentCompany::class)->get();

if ($currentCompany) {
    echo $currentCompany->name;
    echo $currentCompany->id;
}
```

### Checking User's Companies

```php
$user = Auth::user();

// Get all companies user belongs to
$companies = $user->companies()->get();

// Get only active companies
$activeCompanies = $user->accessibleCompanies();

// Check if user belongs to a company
$belongsTo = $user->companies()->where('companies.id', $companyId)->exists();
```

---

## UI Patterns

### 1. Dropdown Switcher (Recommended)

Use the provided Blade component:

```blade
{{-- In your layout/navigation --}}
@include('components.company-switcher')
```

**Features:**
- Shows current company name
- Dropdown with all accessible companies
- Visual indicator for current company
- Only shows if user has multiple companies
- Uses Alpine.js for interactivity

### 2. Full Page Switcher

For a dedicated switching page:

```blade
{{-- Link to switcher page --}}
<a href="{{ route('companies.switch.index') }}">Switch Company</a>
```

**Features:**
- Full list of companies
- Current company highlighted
- Clear company context option
- Better for users with many companies

### 3. AJAX-Based Switcher

For dynamic switching without page reload:

```javascript
// Fetch companies
fetch('/companies/list')
    .then(response => response.json())
    .then(data => {
        // Render company list
        data.companies.forEach(company => {
            // Create switch button
        });
    });

// Switch company
function switchCompany(companyId) {
    fetch(`/companies/switch/${companyId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            redirect_to: window.location.href
        })
    })
    .then(() => {
        window.location.reload();
    });
}
```

### 4. Navigation Bar Integration

Add to your main navigation:

```blade
{{-- In resources/views/layouts/app.blade.php or similar --}}
<nav class="navbar">
    <div class="navbar-brand">Payroll System</div>
    
    <div class="navbar-menu">
        @auth
            {{-- Company Switcher --}}
            <div class="navbar-item">
                @include('components.company-switcher')
            </div>
            
            {{-- Other menu items --}}
        @endauth
    </div>
</nav>
```

---

## Security Features

### 1. Access Verification

Before switching, the system verifies:
- ✅ User belongs to the company
- ✅ Company is active
- ✅ User's membership is active

```php
// In CompanySwitchController@switch
if (! $user->companies()->where('companies.id', $company->id)->exists()) {
    abort(403, 'You do not have access to this company');
}

if (! $company->is_active) {
    return redirect()->back()
        ->with('error', 'This company account is inactive');
}
```

### 2. Session Security

- Company ID stored in session (not in URL)
- Session key configurable via `config('tenancy.session_key')`
- Session automatically cleared on logout

### 3. Audit Logging

Every company switch is logged:

```php
AuditLog::create([
    'company_id'  => $company->id,
    'user_id'     => $user->id,
    'event_type'  => 'company_switched',
    'description' => "Switched to company \"{$company->name}\"",
    'ip_address'  => $request->ip(),
    'user_agent'  => $request->userAgent(),
    'entity_type' => Company::class,
    'entity_id'   => $company->id,
]);
```

### 4. Middleware Protection

The `SetCurrentCompany` middleware:
- Verifies user access before setting company from session
- Falls back to subdomain if session company is invalid
- Prevents unauthorized company access

---

## Configuration

### Session Key

Configure the session key in `config/tenancy.php`:

```php
'session_key' => env('TENANCY_SESSION_KEY', 'current_company_id'),
```

### Detection Priority

Configure detection methods order:

```php
'detection_methods' => [
    'subdomain',  // First: check subdomain
    'header',     // Second: check HTTP header
    'session',    // Third: check session
],
```

For authenticated users without subdomain, session is checked first automatically.

---

## Workflow Examples

### Scenario 1: User with Multiple Companies

1. User logs in
2. User visits `/companies/switch`
3. Sees list of companies they belong to
4. Clicks "Switch" on a company
5. Company ID stored in session
6. Redirected to company dashboard
7. All subsequent requests use session company

### Scenario 2: Subdomain + Session

1. User is on `acme.app.test` (subdomain)
2. Subdomain takes priority, sets company to "Acme"
3. User switches to "Beta Corp" via switcher
4. Session stores "Beta Corp" ID
5. If user visits main domain (no subdomain), session company is used
6. If user visits `acme.app.test` again, subdomain takes priority

### Scenario 3: Clearing Company Context

1. User clicks "Clear company context"
2. Session key is removed
3. User redirected to home page
4. No company context until they switch or visit subdomain

---

## Best Practices

### 1. Always Verify Access

```php
// ✅ Good
if (! $user->companies()->where('companies.id', $company->id)->exists()) {
    abort(403);
}

// ❌ Bad - No verification
Session::put('current_company_id', $request->company_id);
```

### 2. Use Helper Methods

```php
// ✅ Good
$companies = $user->accessibleCompanies();

// ❌ Bad - Manual query
$companies = $user->companies()
    ->where('company_user.status', 'active')
    ->where('companies.is_active', true)
    ->get();
```

### 3. Provide User Feedback

```php
// ✅ Good
return redirect($redirectTo)
    ->with('success', sprintf('Switched to %s', $company->name));

// ❌ Bad - No feedback
return redirect($redirectTo);
```

### 4. Log Important Actions

All company switches are automatically logged for audit purposes. This helps with:
- Security monitoring
- Compliance requirements
- Debugging access issues

---

## Troubleshooting

### Issue: Company not switching

**Solution:**
1. Check session is working (`php artisan session:table`)
2. Verify user belongs to company
3. Check company is active
4. Review middleware order

### Issue: Wrong company after switch

**Solution:**
1. Clear session: `Session::forget('current_company_id')`
2. Check subdomain priority (subdomain overrides session)
3. Verify middleware is running

### Issue: Access denied after switch

**Solution:**
1. Verify user's membership status is 'active'
2. Check company is_active flag
3. Review audit logs for access attempts

---

## Testing

### Unit Tests

```php
public function test_user_can_switch_company()
{
    $user = User::factory()->create();
    $company1 = Company::factory()->create();
    $company2 = Company::factory()->create();
    
    $user->companies()->attach([$company1->id, $company2->id]);
    
    $this->actingAs($user)
        ->post(route('companies.switch.store', $company2))
        ->assertRedirect();
    
    $this->assertEquals($company2->id, session('current_company_id'));
}

public function test_user_cannot_switch_to_unauthorized_company()
{
    $user = User::factory()->create();
    $company = Company::factory()->create();
    
    $this->actingAs($user)
        ->post(route('companies.switch.store', $company))
        ->assertStatus(403);
}
```

---

## API Reference

### Routes

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/companies/switch` | `companies.switch.index` | Show switcher page |
| POST | `/companies/switch/{company}` | `companies.switch.store` | Switch to company |
| POST | `/companies/clear` | `companies.switch.clear` | Clear company context |
| GET | `/companies/list` | `companies.list` | JSON list of companies |

### Controller Methods

**`CompanySwitchController@switch`**

Parameters:
- `Company $company` - Company to switch to

Request body (optional):
- `redirect_to` - URL to redirect after switch

Returns: Redirect response

---

## Future Enhancements

Potential improvements:
- [ ] Remember last company per user (database)
- [ ] Quick switch keyboard shortcut
- [ ] Company favorites
- [ ] Recent companies list
- [ ] Company search/filter
- [ ] Bulk operations across companies (for super admins)

---

## Support

For issues or questions:
- Check audit logs for access attempts
- Review middleware stack
- Verify session configuration
- Check company membership status
