# Security Implementation Guide

This document outlines the security hardening measures implemented for the payroll SaaS system handling sensitive salary data.

## Table of Contents

1. [Encrypted Salary Fields](#1-encrypted-salary-fields)
2. [Audit Logs for Payroll Changes](#2-audit-logs-for-payroll-changes)
3. [Activity Tracking](#3-activity-tracking)
4. [Role-Based Authorization](#4-role-based-authorization)
5. [Secure File Storage for Payslips](#5-secure-file-storage-for-payslips)
6. [Usage Examples](#6-usage-examples)
7. [Best Practices](#7-best-practices)

---

## 1. Encrypted Salary Fields

### Implementation

All sensitive financial and personal data is encrypted at rest using Laravel's `Crypt` facade.

### Custom Casts Created

**`app/Casts/EncryptedDecimal.php`** - For financial amounts
```php
use App\Casts\EncryptedDecimal;

protected $casts = [
    'gross_amount' => EncryptedDecimal::class,
    'net_amount' => EncryptedDecimal::class,
];
```

**`app/Casts/EncryptedString.php`** - For sensitive text fields
```php
use App\Casts\EncryptedString;

protected $casts = [
    'bank_account_number' => EncryptedString::class,
    'tax_number' => EncryptedString::class,
];
```

### Models with Encryption

#### PayrollItem
- `gross_amount`
- `total_earnings`
- `total_deductions`
- `total_contributions`
- `net_amount`

#### Payslip
- `gross_amount`
- `total_earnings`
- `total_deductions`
- `net_amount`

#### PayrollRun
- `total_gross_amount`
- `total_net_amount`

#### PayrollItemDetail
- `base_amount`
- `calculated_amount`

#### Employee
- `national_id`
- `bank_account_number`
- `tax_number`
- `social_security_number`

### How It Works

- **Automatic Encryption**: Data is encrypted when saving to database
- **Automatic Decryption**: Data is decrypted when reading from database
- **Transparent**: No code changes needed in controllers/services - works automatically
- **Error Handling**: Gracefully handles decryption failures (logs warning, returns null)

### Example Usage

```php
// Creating a payroll item - encryption happens automatically
$payrollItem = PayrollItem::create([
    'gross_amount' => 5000.00,  // Automatically encrypted before save
    'net_amount' => 4500.00,     // Automatically encrypted before save
]);

// Reading - decryption happens automatically
$gross = $payrollItem->gross_amount;  // Returns 5000.00 (decrypted)
```

---

## 2. Audit Logs for Payroll Changes

### Implementation

The `Auditable` trait automatically logs all model changes to the `audit_logs` table.

### Trait: `app/Models/Traits/Auditable.php`

Automatically logs:
- **Created** events
- **Updated** events (with old/new values)
- **Deleted** events

### What Gets Logged

- User ID (who made the change)
- Company ID (which company)
- Event type (created/updated/deleted)
- IP address
- User agent
- Entity type and ID
- Old values (JSON)
- New values (JSON)
- Timestamp

### Models with Auditing

- `PayrollItem`
- `Payslip`
- `PayrollRun`
- `PayrollItemDetail`
- `Employee`

### Example Audit Log Entry

```json
{
  "company_id": 1,
  "user_id": 5,
  "event_type": "updated",
  "description": "Payroll Run \"Monthly payroll January 2024\" updated (ID: 123)",
  "ip_address": "192.168.1.100",
  "user_agent": "Mozilla/5.0...",
  "entity_type": "App\\Models\\PayrollRun",
  "entity_id": 123,
  "old_values": {"status": "draft", "total_gross_amount": "50000.00"},
  "new_values": {"status": "completed", "total_gross_amount": "50000.00"},
  "created_at": "2024-01-15 10:30:00"
}
```

### Querying Audit Logs

```php
// Get all audit logs for a company
$logs = AuditLog::where('company_id', $companyId)
    ->orderBy('created_at', 'desc')
    ->get();

// Get audit logs for a specific payroll run
$logs = AuditLog::where('entity_type', PayrollRun::class)
    ->where('entity_id', $payrollRunId)
    ->get();

// Get all payroll-related changes
$logs = AuditLog::where('event_type', 'payroll_approved')
    ->get();
```

---

## 3. Activity Tracking

### Manual Audit Logging

For specific actions that need explicit tracking:

#### Payslip Downloads

Automatically logged in `PayslipController@download`:

```php
AuditLog::create([
    'company_id'  => $payslip->company_id,
    'user_id'     => $request->user()->id,
    'event_type'  => 'payslip_download',
    'description' => "Payslip {$payslip->payslip_number} downloaded",
    'ip_address'  => $request->ip(),
    'user_agent'  => $request->userAgent(),
    'entity_type' => Payslip::class,
    'entity_id'   => $payslip->id,
]);
```

#### Payroll Approvals

Automatically logged in `PayrollRunService@approveAndLock`:

```php
AuditLog::create([
    'company_id'  => $run->company_id,
    'user_id'     => Auth::id(),
    'event_type'  => 'payroll_approved',
    'description' => sprintf('Payroll run "%s" (ID: %s) approved and locked', $run->name, $run->id),
    'ip_address'  => request()?->ip(),
    'user_agent'  => request()?->userAgent(),
    'entity_type' => PayrollRun::class,
    'entity_id'   => $run->id,
    'new_values'  => json_encode([
        'status'      => 'closed',
        'approved_by' => Auth::id(),
        'approved_at' => now()->toDateTimeString(),
    ]),
]);
```

### Tracking User Activity

```php
// Get all activity for a user
$activity = AuditLog::where('user_id', $userId)
    ->orderBy('created_at', 'desc')
    ->paginate(20);

// Get activity by event type
$downloads = AuditLog::where('event_type', 'payslip_download')
    ->where('user_id', $userId)
    ->get();
```

---

## 4. Role-Based Authorization

### Policies Created

#### `app/Policies/PayrollRunPolicy.php`

Methods:
- `view()` - Company admins and payroll managers
- `create()` - Company admins and payroll managers
- `update()` - Company admins only
- `approve()` - Company admins only
- `delete()` - Company admins only (if not locked)

#### `app/Policies/PayslipPolicy.php`

Methods:
- `view()` - Employee (own payslip) or company admins/payroll managers
- `download()` - Same as view

### Usage in Controllers

```php
// In PayrollRunController
public function approve(PayrollRun $run)
{
    $this->authorize('approve', $run);
    
    $this->payrollRunService->approveAndLock($run);
    
    return redirect()->route('payroll-runs.index')
        ->with('success', 'Payroll run approved and locked.');
}

// In PayslipController
public function download(Request $request, Payslip $payslip)
{
    Gate::authorize('download', $payslip);
    
    // Secure download logic...
}
```

### Role Checking

The `User` model has a `hasRoleInCompany()` method:

```php
// Check if user has a role in a company
if ($user->hasRoleInCompany('company_admin', $companyId)) {
    // User is admin
}

if ($user->hasRoleInCompany('payroll_manager', $companyId)) {
    // User is payroll manager
}
```

### Route Protection

```php
// In routes/web.php
Route::middleware(['auth', 'role:company_admin'])
    ->group(function () {
        Route::post('/payroll-runs/{run}/approve', [PayrollRunController::class, 'approve'])
            ->name('payroll-runs.approve');
    });
```

---

## 5. Secure File Storage for Payslips

### Private Storage Disk

Configured in `config/filesystems.php`:

```php
'payslips' => [
    'driver' => 'local',
    'root' => storage_path('app/payslips'),
    'visibility' => 'private',
],
```

### Storage Location

- **Path**: `storage/app/payslips/{company_id}/{payslip_number}-{uuid}.pdf`
- **Not publicly accessible** - Files are NOT in `public/` directory
- **Access**: Only through authorized controller routes

### PayslipService Implementation

```php
// Generate and store PDF
protected function renderPdf(Payslip $payslip, PayrollItem $item): string
{
    $pdf = PDF::loadView('payslips.pdf', $data)->setPaper('A4');
    
    $fileName = sprintf(
        '%s/%s-%s.pdf',
        $company->id,
        $payslip->payslip_number,
        Str::uuid()
    );
    
    // Store in private disk
    Storage::disk('payslips')->put($fileName, $pdf->output());
    
    return $fileName; // Return relative path
}
```

### Secure Download

```php
// In PayslipController@download
public function download(Request $request, Payslip $payslip)
{
    Gate::authorize('download', $payslip);
    
    $disk = Storage::disk('payslips');
    
    if (! $disk->exists($payslip->pdf_url)) {
        abort(404, 'Payslip file not found');
    }
    
    // Log the download
    AuditLog::create([...]);
    
    // Secure download from private storage
    return $disk->download($payslip->pdf_url, $payslip->payslip_number . '.pdf');
}
```

### Email Attachments

```php
// In PayslipMail@build
if ($this->payslip->pdf_url) {
    $disk = Storage::disk('payslips');
    if ($disk->exists($this->payslip->pdf_url)) {
        $mail->attachFromStorageDisk('payslips', $this->payslip->pdf_url, 
            $this->payslip->payslip_number . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
```

---

## 6. Usage Examples

### Creating a Payroll Run (with automatic encryption and auditing)

```php
$run = PayrollRun::create([
    'company_id' => $companyId,
    'name' => 'Monthly Payroll January 2024',
    'period_start_date' => '2024-01-01',
    'period_end_date' => '2024-01-31',
    'pay_date' => '2024-02-05',
    'total_gross_amount' => 50000.00,  // Automatically encrypted
    'total_net_amount' => 45000.00,    // Automatically encrypted
]);

// Audit log automatically created
```

### Approving Payroll (with audit logging)

```php
$payrollRunService->approveAndLock($run);

// This automatically:
// 1. Updates status to 'closed'
// 2. Locks all payroll items
// 3. Creates audit log entry
// 4. Generates payslips
// 5. Emails payslips to employees
```

### Downloading Payslip (with authorization and audit logging)

```php
// Route: GET /employee/payslips/{payslip}/download
// Automatically:
// 1. Checks authorization (employee can only download own payslip)
// 2. Verifies file exists in private storage
// 3. Creates audit log entry
// 4. Downloads file securely
```

### Querying Audit Logs

```php
// Get all changes to a payroll run
$auditTrail = AuditLog::where('entity_type', PayrollRun::class)
    ->where('entity_id', $runId)
    ->orderBy('created_at')
    ->get();

// Get all payslip downloads by a user
$downloads = AuditLog::where('event_type', 'payslip_download')
    ->where('user_id', $userId)
    ->get();

// Get all payroll approvals in a date range
$approvals = AuditLog::where('event_type', 'payroll_approved')
    ->where('company_id', $companyId)
    ->whereBetween('created_at', [$startDate, $endDate])
    ->get();
```

---

## 7. Best Practices

### Encryption

1. **Never log encrypted values** - Only log that a change occurred
2. **Handle decryption failures gracefully** - Log warnings, return null
3. **Use appropriate cast types** - `EncryptedDecimal` for amounts, `EncryptedString` for text
4. **Keep APP_KEY secure** - Encryption depends on Laravel's encryption key

### Audit Logging

1. **Log all sensitive operations** - Payroll changes, approvals, downloads
2. **Include context** - IP address, user agent, timestamps
3. **Store old/new values** - For compliance and debugging
4. **Regular cleanup** - Archive old logs to prevent table bloat

### Authorization

1. **Use policies consistently** - Don't bypass authorization checks
2. **Check company membership** - Always verify user belongs to company
3. **Principle of least privilege** - Only grant minimum required access
4. **Test authorization** - Write tests for policy methods

### File Storage

1. **Never store in public directory** - Use private storage for sensitive files
2. **Use unique filenames** - Include UUIDs to prevent guessing
3. **Verify authorization** - Always check permissions before serving files
4. **Log all access** - Track who downloads what and when

### General Security

1. **HTTPS only** - All traffic must be encrypted in transit
2. **Strong passwords** - Enforce password policies
3. **Rate limiting** - Prevent brute force attacks
4. **Regular security audits** - Review access logs and permissions
5. **Backup encryption** - Encrypt database backups
6. **Access monitoring** - Alert on suspicious activity patterns

---

## Security Checklist

- ✅ All salary fields encrypted at rest
- ✅ All sensitive personal data encrypted
- ✅ Complete audit trail for all changes
- ✅ Activity tracking for downloads and approvals
- ✅ Role-based authorization with policies
- ✅ Secure private storage for payslips
- ✅ Authorization checks on all sensitive routes
- ✅ Audit logging for all sensitive operations
- ✅ Company isolation (multi-tenancy)
- ✅ Secure file downloads with authorization

---

## Compliance Notes

This implementation helps meet requirements for:
- **GDPR** - Data encryption, access controls, audit trails
- **SOC 2** - Security controls, audit logging, access management
- **ISO 27001** - Information security management
- **PCI DSS** - If handling payment data (encryption, access controls)

---

## Maintenance

### Regular Tasks

1. **Review audit logs weekly** - Check for suspicious activity
2. **Rotate encryption keys** - If compromised (requires data migration)
3. **Archive old logs** - Move logs older than 1 year to archive
4. **Review user permissions** - Ensure users have minimum required access
5. **Update dependencies** - Keep Laravel and packages updated for security patches

### Monitoring

Monitor for:
- Unusual download patterns (multiple payslips by same user)
- Failed authorization attempts
- Changes to payroll data outside business hours
- Access from unusual IP addresses

---

## Support

For questions or issues with security implementation, refer to:
- Laravel Encryption: https://laravel.com/docs/encryption
- Laravel Policies: https://laravel.com/docs/authorization#creating-policies
- Laravel Storage: https://laravel.com/docs/filesystem
