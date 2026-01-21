<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payslip - {{ $payslip->payslip_number }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #111827; }
        .header, .footer { width: 100%; }
        .header { margin-bottom: 20px; }
        .company-name { font-size: 18px; font-weight: bold; }
        .section-title { font-size: 14px; font-weight: bold; margin-top: 20px; margin-bottom: 5px; border-bottom: 1px solid #e5e7eb; padding-bottom: 3px; }
        table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        th, td { padding: 6px 8px; border: 1px solid #e5e7eb; }
        th { background-color: #f3f4f6; text-align: left; }
        .text-right { text-align: right; }
        .totals { margin-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ $company->legal_name ?? $company->name }}</div>
        <div>
            {{ $company->address_line1 }}<br>
            {{ $company->city }}, {{ $company->state }} {{ $company->postal_code }}<br>
            Tax ID: {{ $company->tax_id }}
        </div>
    </div>

    <div>
        <strong>Payslip #:</strong> {{ $payslip->payslip_number }}<br>
        <strong>Period:</strong>
        {{ format_localized_date($payslip->payrollRun->period_start_date) }}
        to
        {{ format_localized_date($payslip->payrollRun->period_end_date) }}<br>
        <strong>Pay Date:</strong> {{ format_localized_date($payslip->payrollRun->pay_date) }}<br>
        <strong>Issue Date:</strong> {{ format_localized_date($payslip->issue_date) }}
    </div>

    <div class="section-title">Employee Information</div>
    <table>
        <tr>
            <th>Name</th>
            <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
            <th>Employee Code</th>
            <td>{{ $employee->employee_code }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $employee->email }}</td>
            <th>Tax Number</th>
            <td>{{ $employee->tax_number }}</td>
        </tr>
        <tr>
            <th>Job Title</th>
            <td>{{ $employee->job_title }}</td>
            <th>Pay Frequency</th>
            <td>{{ $employee->pay_frequency }}</td>
        </tr>
    </table>

    <div class="section-title">Earnings</div>
    <table>
        <thead>
            <tr>
                <th>Component</th>
                <th class="text-right">Amount ({{ $payslip->currency }})</th>
            </tr>
        </thead>
        <tbody>
            @php $earningsTotal = 0; @endphp
            @foreach($details->where('component_type', 'earning') as $detail)
                @php $earningsTotal += $detail->calculated_amount; @endphp
                <tr>
                    <td>{{ $detail->component_name }}</td>
                    <td class="text-right">{{ format_money($detail->calculated_amount, $payslip->currency) }}</td>
                </tr>
            @endforeach
            <tr>
                <th>Total Earnings</th>
                <th class="text-right">{{ format_money($earningsTotal, $payslip->currency) }}</th>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Deductions</div>
    <table>
        <thead>
            <tr>
                <th>Component</th>
                <th class="text-right">Amount ({{ $payslip->currency }})</th>
            </tr>
        </thead>
        <tbody>
            @php $deductionsTotal = 0; @endphp
            @foreach($details->where('component_type', 'deduction') as $detail)
                @php $deductionsTotal += $detail->calculated_amount; @endphp
                <tr>
                    <td>{{ $detail->component_name }}</td>
                    <td class="text-right">{{ format_money($detail->calculated_amount, $payslip->currency) }}</td>
                </tr>
            @endforeach
            <tr>
                <th>Total Deductions</th>
                <th class="text-right">{{ format_money($deductionsTotal, $payslip->currency) }}</th>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Summary</div>
    <table class="totals">
        <tr>
            <th>Gross Pay</th>
            <td class="text-right">{{ format_money($payslip->gross_amount, $payslip->currency) }}</td>
        </tr>
        <tr>
            <th>Total Deductions</th>
            <td class="text-right">{{ format_money($payslip->total_deductions, $payslip->currency) }}</td>
        </tr>
        <tr>
            <th>Net Pay</th>
            <td class="text-right"><strong>{{ format_money($payslip->net_amount, $payslip->currency) }}</strong></td>
        </tr>
    </table>

    <div class="footer" style="margin-top: 30px; font-size: 10px; color: #6b7280;">
        This payslip was generated electronically and does not require a physical signature.
    </div>
</body>
</html>

