<p>Hi {{ $employee->first_name }},</p>

<p>Your payslip for the period ending
    {{ optional($payslip->payrollRun->period_end_date)->format('F j, Y') ?? now()->toFormattedDateString() }}
    is now available.
</p>

<p>
    <strong>Net pay:</strong>
    {{ $payslip->currency }} {{ number_format($payslip->net_amount, 2) }}
</p>

<p>
    You can view or download your payslip by logging into your employee portal,
    or by opening the attached PDF.
</p>

<p>Regards,<br>{{ $company->legal_name ?? $company->name }}</p>

