# Payroll Compliance Reporting Architecture

## Overview

The payroll compliance reporting system provides multi-tenant, role-based access to generate tax summaries, pension/NSSF contribution reports, and annual payroll summaries. All reports support export to PDF and Excel formats.

## Architecture Components

### 1. Service Layer (`app/Services/Reporting/`)

#### BaseReport (`BaseReport.php`)
Abstract base class for all report types:
- Handles company context and date period management
- Provides common methods: `toCollection()`, `toArray()`, `getTitle()`, `getDescription()`
- All concrete report classes extend this

#### ReportExporter (`ReportExporter.php`)
Handles export generation:
- **PDF Export**: Uses `barryvdh/laravel-dompdf` to generate PDFs from Blade views
- **Excel Export**: Uses `maatwebsite/excel` (Laravel Excel) for spreadsheet generation
- Methods: `toPdf()`, `toExcel()`, `downloadPdf()`, `downloadExcel()`
- Automatically styles Excel exports with headers and auto-sized columns

#### Concrete Report Classes

**TaxSummaryReport** (`TaxSummaryReport.php`)
- Aggregates tax deductions from `payroll_item_details` where `component_type = 'deduction'`
- Matches tax components by code/name patterns: `TAX`, `INCOME_TAX`, `PAYE`, `WITHHOLDING_TAX`, or names containing "tax", "PAYE", "withholding"
- Groups by employee and provides totals
- Output: Summary totals + per-employee breakdown

**PensionReport** (`PensionReport.php`)
- Aggregates pension/NSSF contributions from `payroll_item_details` where `component_type = 'contribution'`
- Separates employee vs employer contributions
- Matches by codes: `PENSION`, `NSSF`, `SSNIT`, `PENSION_EMPLOYEE`, `PENSION_EMPLOYER`, etc.
- Output: Summary totals + per-employee breakdown with employee/employer split

**AnnualPayrollSummaryReport** (`AnnualPayrollSummaryReport.php`)
- Aggregates all payslips for a given year
- Extracts tax and pension from related `payroll_item_details`
- Provides comprehensive annual summary per employee
- Output: Company-wide summary + per-employee annual totals

### 2. Controller Layer (`app/Http/Controllers/Reports/`)

All controllers:
- Require authentication and `company_admin` or `payroll_officer` role
- Use form request validation
- Resolve current company from `CurrentCompany` service
- Generate reports and return downloads

**TaxReportController**
- `index()`: Display form for tax report generation
- `generate()`: Generate and download tax report (PDF/Excel)

**PensionReportController**
- `index()`: Display form for pension report generation
- `generate()`: Generate and download pension report (PDF/Excel)

**AnnualPayrollReportController**
- `index()`: Display form for annual report generation
- `generate()`: Generate and download annual summary (PDF/Excel)

### 3. Request Validation (`app/Http/Requests/Reports/`)

**GenerateTaxReportRequest**
- Validates: `period_start` (optional date), `period_end` (optional date, after start), `format` (pdf/excel)
- Authorizes: `super_admin`, `company_admin`, `payroll_officer`

**GeneratePensionReportRequest**
- Same validation as tax report

**GenerateAnnualReportRequest**
- Validates: `year` (required, 2000 to current+1), `format` (pdf/excel)
- Authorizes: Same roles as above

### 4. View Layer (`resources/views/reports/`)

**Index Pages** (`index.blade.php`, `tax/index.blade.php`, `pension/index.blade.php`, `annual/index.blade.php`)
- Form-based UI for report generation
- Date pickers, format selection
- Extends `layouts.app` (assumes standard Laravel layout)

**PDF Views** (`tax/pdf.blade.php`, `pension/pdf.blade.php`, `annual/pdf.blade.php`)
- Professional PDF layouts matching payslip styling
- Company header with legal name, address, tax ID
- Summary boxes for totals
- Detailed tables with employee data
- Footer with generation timestamp and confidentiality notice

### 5. Routes (`routes/web.php`)

All report routes are:
- Scoped to tenant subdomain (`{company}.app.test`)
- Protected by: `web`, `SetCurrentCompany`, `auth`, `subscribed` middleware
- Further restricted to `company_admin` role
- Prefixed with `/admin/reports`

Routes:
- `GET /admin/reports` → Reports index page
- `GET /admin/reports/tax` → Tax report form
- `POST /admin/reports/tax/generate` → Generate tax report
- `GET /admin/reports/pension` → Pension report form
- `POST /admin/reports/pension/generate` → Generate pension report
- `GET /admin/reports/annual` → Annual report form
- `POST /admin/reports/annual/generate` → Generate annual report

### 6. Data Model Integration

Reports query from:
- **Payslips**: `payslips` table (company-scoped via `BelongsToCompany` trait)
- **Payroll Items**: `payroll_items` table (links payslips to calculations)
- **Payroll Item Details**: `payroll_item_details` table (component-level breakdown)
  - `component_type`: `'earning'`, `'deduction'`, `'contribution'`
  - `component_code`: e.g., `'TAX'`, `'PENSION'`, `'NSSF'`
  - `component_name`: Human-readable name
  - `calculated_amount`: The actual amount

**Multi-Tenant Scoping**:
- All queries automatically scoped by `company_id` via `BelongsToCompany` trait
- `CurrentCompany` service ensures correct tenant context
- No cross-tenant data leakage possible

### 7. Audit Trail (Optional)

**Migration**: `2026_01_21_000005_create_report_runs_table.php`

The `report_runs` table tracks:
- Which reports were generated
- When and by whom
- Storage path to generated files
- Status (queued, processing, completed, failed)
- Error messages if generation failed

**Future Enhancement**: Controllers can be updated to log report runs for audit compliance.

## Usage Examples

### Generate Tax Summary Report (PDF)
```php
// Via HTTP
POST /admin/reports/tax/generate
{
    "period_start": "2024-01-01",
    "period_end": "2024-12-31",
    "format": "pdf"
}
```

### Generate Pension Report (Excel)
```php
// Via HTTP
POST /admin/reports/pension/generate
{
    "period_start": "2024-01-01",
    "period_end": "2024-12-31",
    "format": "excel"
}
```

### Generate Annual Summary (PDF)
```php
// Via HTTP
POST /admin/reports/annual/generate
{
    "year": 2024,
    "format": "pdf"
}
```

### Programmatic Usage
```php
use App\Services\Reporting\TaxSummaryReport;
use App\Services\Reporting\ReportExporter;
use App\Tenancy\CurrentCompany;

$company = app(CurrentCompany::class)->get();
$report = new TaxSummaryReport($company, now()->startOfMonth(), now()->endOfMonth());
$data = $report->toCollection();

$exporter = new ReportExporter();
$pdfPath = $exporter->toPdf($data, 'reports.tax.pdf', 'Tax Summary', $company);
```

## Security Considerations

1. **Multi-Tenant Isolation**: All queries use `BelongsToCompany` trait ensuring `company_id` is always enforced
2. **Role-Based Access**: Only `company_admin` and `payroll_officer` can generate reports
3. **Subscription Gating**: Reports require active subscription (`subscribed` middleware)
4. **Data Encryption**: Financial data uses `EncryptedDecimal` cast (handled by existing models)

## Extending the System

### Adding a New Report Type

1. Create report class extending `BaseReport`:
```php
class CustomReport extends BaseReport
{
    public function toCollection(): Collection { /* ... */ }
    public function getTitle(): string { return 'Custom Report'; }
}
```

2. Create controller:
```php
class CustomReportController extends Controller
{
    public function generate(GenerateCustomReportRequest $request) { /* ... */ }
}
```

3. Create form request for validation
4. Create Blade views (index form + PDF template)
5. Add routes to `routes/web.php`

### Customizing Component Matching

Reports identify tax/pension components by:
- `component_code` matching known codes (e.g., `'TAX'`, `'PENSION'`)
- `component_name` containing keywords (e.g., "tax", "pension", "NSSF")

To customize matching, modify the `where()` clauses in report classes or add a configuration file mapping component codes to report categories.

## Dependencies

- `barryvdh/laravel-dompdf`: PDF generation
- `maatwebsite/excel`: Excel export (already in composer.json)
- Laravel 12+ with standard authentication

## Notes

- Reports are generated on-demand (no queuing by default, but can be added)
- PDF views use DejaVu Sans font (standard for DomPDF)
- Excel exports include auto-styled headers and auto-sized columns
- All financial amounts are formatted with 2 decimal places
- Reports include company branding (name, address, tax ID) from `Company` model
