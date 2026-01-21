<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 10px; color: #111827; }
        .header { margin-bottom: 20px; }
        .company-name { font-size: 18px; font-weight: bold; }
        .report-title { font-size: 16px; font-weight: bold; margin: 15px 0; }
        .section-title { font-size: 13px; font-weight: bold; margin-top: 15px; margin-bottom: 8px; border-bottom: 2px solid #374151; padding-bottom: 3px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 9px; }
        th, td { padding: 6px 4px; border: 1px solid #d1d5db; }
        th { background-color: #f3f4f6; font-weight: bold; text-align: left; }
        .text-right { text-align: right; }
        .summary-box { background-color: #f9fafb; padding: 10px; margin: 15px 0; border: 1px solid #e5e7eb; }
        .footer { margin-top: 30px; font-size: 9px; color: #6b7280; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ $company->legal_name ?? $company->name }}</div>
        <div style="font-size: 10px; margin-top: 5px;">
            @if($company->address_line1)
                {{ $company->address_line1 }}<br>
                @if($company->city){{ $company->city }}, @endif
                @if($company->state){{ $company->state }} @endif
                @if($company->postal_code){{ $company->postal_code }}@endif<br>
            @endif
            @if($company->tax_id)Tax ID: {{ $company->tax_id }}@endif
        </div>
    </div>

    <div class="report-title">{{ $title }}</div>

    <div>
        <strong>Year:</strong> {{ $year ?? now()->year }}<br>
        <strong>Generated:</strong> {{ $generatedAt->format('M d, Y H:i:s') }}<br>
        @if(isset($requestedBy))
            <strong>Requested By:</strong> {{ $requestedBy->name }}<br>
        @endif
    </div>

    @if(isset($data['summary']))
    <div class="summary-box">
        <div class="section-title" style="border: none; margin: 0; padding: 0;">Company Summary</div>
        <table style="border: none;">
            <tr>
                <td style="border: none;"><strong>Total Employees:</strong></td>
                <td style="border: none; text-align: right;">{{ number_format($data['summary']['total_employees']) }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Total Gross Pay:</strong></td>
                <td style="border: none; text-align: right;">{{ number_format($data['summary']['total_gross'], 2) }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Total Earnings:</strong></td>
                <td style="border: none; text-align: right;">{{ number_format($data['summary']['total_earnings'], 2) }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Total Tax:</strong></td>
                <td style="border: none; text-align: right;">{{ number_format($data['summary']['total_tax'], 2) }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Total Pension/NSSF:</strong></td>
                <td style="border: none; text-align: right;">{{ number_format($data['summary']['total_pension'], 2) }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Other Deductions:</strong></td>
                <td style="border: none; text-align: right;">{{ number_format($data['summary']['total_other_deductions'], 2) }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Total Deductions:</strong></td>
                <td style="border: none; text-align: right;">{{ number_format($data['summary']['total_deductions'], 2) }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Total Net Pay:</strong></td>
                <td style="border: none; text-align: right;"><strong>{{ number_format($data['summary']['total_net'], 2) }}</strong></td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Total Payslips:</strong></td>
                <td style="border: none; text-align: right;">{{ number_format($data['summary']['total_payslips']) }}</td>
            </tr>
        </table>
    </div>
    @endif

    <div class="section-title">Employee Annual Summary</div>
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Tax #</th>
                <th>SSN</th>
                <th class="text-right">Gross</th>
                <th class="text-right">Earnings</th>
                <th class="text-right">Tax</th>
                <th class="text-right">Pension</th>
                <th class="text-right">Other Ded.</th>
                <th class="text-right">Deductions</th>
                <th class="text-right">Net</th>
                <th>Payslips</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data['employees'] ?? [] as $employee)
                <tr>
                    <td>{{ $employee['employee_code'] }}</td>
                    <td>{{ $employee['employee_name'] }}</td>
                    <td>{{ $employee['tax_number'] }}</td>
                    <td>{{ $employee['social_security_number'] }}</td>
                    <td class="text-right">{{ number_format($employee['total_gross'], 2) }}</td>
                    <td class="text-right">{{ number_format($employee['total_earnings'], 2) }}</td>
                    <td class="text-right">{{ number_format($employee['total_tax'], 2) }}</td>
                    <td class="text-right">{{ number_format($employee['total_pension'], 2) }}</td>
                    <td class="text-right">{{ number_format($employee['other_deductions'], 2) }}</td>
                    <td class="text-right">{{ number_format($employee['total_deductions'], 2) }}</td>
                    <td class="text-right"><strong>{{ number_format($employee['total_net'], 2) }}</strong></td>
                    <td>{{ $employee['payslip_count'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" style="text-align: center; padding: 20px;">No payroll data found for the selected year.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        This report was generated electronically by {{ config('app.name') }}.<br>
        Confidential - For internal use only. Annual payroll summary for financial reporting and compliance.
    </div>
</body>
</html>
