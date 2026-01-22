<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            margin-bottom: 30px;
        }
        .company-info {
            margin-bottom: 20px;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .total {
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Invoice {{ $invoice->invoice_number }}</h1>
    </div>

    <div class="company-info">
        <strong>{{ $invoice->company->name }}</strong><br>
        @if($invoice->company->address_line1)
        {{ $invoice->company->address_line1 }}<br>
        @endif
        @if($invoice->company->address_line2)
        {{ $invoice->company->address_line2 }}<br>
        @endif
        @if($invoice->company->city)
        {{ $invoice->company->city }}, {{ $invoice->company->state ?? '' }} {{ $invoice->company->postal_code ?? '' }}<br>
        @endif
    </div>

    <div class="invoice-details">
        <table>
            <tr>
                <td><strong>Issue Date:</strong></td>
                <td>{{ $invoice->issue_date->format('M d, Y') }}</td>
            </tr>
            @if($invoice->due_date)
            <tr>
                <td><strong>Due Date:</strong></td>
                <td>{{ $invoice->due_date->format('M d, Y') }}</td>
            </tr>
            @endif
            <tr>
                <td><strong>Status:</strong></td>
                <td>{{ strtoupper($invoice->status) }}</td>
            </tr>
            @if($invoice->period_start_date && $invoice->period_end_date)
            <tr>
                <td><strong>Period:</strong></td>
                <td>{{ $invoice->period_start_date->format('M d, Y') }} - {{ $invoice->period_end_date->format('M d, Y') }}</td>
            </tr>
            @endif
        </table>
    </div>

    @if($invoice->items->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-right">Quantity</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->description }}</td>
                <td class="text-right">{{ $item->quantity ?? 1 }}</td>
                <td class="text-right">{{ $invoice->currency }} {{ number_format($item->unit_price, 2) }}</td>
                <td class="text-right">{{ $invoice->currency }} {{ number_format($item->line_total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div style="margin-top: 20px;">
        <table>
            <tr>
                <td class="text-right"><strong>Subtotal:</strong></td>
                <td class="text-right">{{ $invoice->currency }} {{ number_format($invoice->subtotal_amount, 2) }}</td>
            </tr>
            @if($invoice->tax_amount > 0)
            <tr>
                <td class="text-right"><strong>Tax:</strong></td>
                <td class="text-right">{{ $invoice->currency }} {{ number_format($invoice->tax_amount, 2) }}</td>
            </tr>
            @endif
            <tr class="total">
                <td class="text-right"><strong>Total:</strong></td>
                <td class="text-right">{{ $invoice->currency }} {{ number_format($invoice->total_amount, 2) }}</td>
            </tr>
            @if($invoice->amount_paid > 0)
            <tr>
                <td class="text-right"><strong>Amount Paid:</strong></td>
                <td class="text-right">{{ $invoice->currency }} {{ number_format($invoice->amount_paid, 2) }}</td>
            </tr>
            @endif
        </table>
    </div>

    @if($invoice->notes)
    <div style="margin-top: 30px;">
        <strong>Notes:</strong><br>
        {{ $invoice->notes }}
    </div>
    @endif
</body>
</html>
