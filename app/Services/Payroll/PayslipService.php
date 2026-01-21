<?php

namespace App\Services\Payroll;

use App\Models\AuditLog;
use App\Models\Employee;
use App\Models\PayrollItem;
use App\Models\PayrollRun;
use App\Models\Payslip;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF; // requires a PDF package such as barryvdh/laravel-dompdf

class PayslipService
{
    /**
     * Generate payslips (records + PDFs) for all items in a payroll run.
     */
    public function generateForRun(PayrollRun $run): void
    {
        DB::transaction(function () use ($run) {
            /** @var \Illuminate\Support\Collection<int,PayrollItem> $items */
            $items = $run->items()->with(['employee', 'details', 'employee.company'])->get();

            foreach ($items as $item) {
                $this->generateForItem($item);
            }
        });
    }

    /**
     * Generate a single payslip for a payroll item.
     */
    public function generateForItem(PayrollItem $item): Payslip
    {
        /** @var Employee $employee */
        $employee = $item->employee()->with('company')->firstOrFail();
        $company  = $employee->company;

        $payslip = Payslip::updateOrCreate(
            [
                'company_id'     => $item->company_id,
                'payroll_run_id' => $item->payroll_run_id,
                'employee_id'    => $item->employee_id,
            ],
            [
                'payslip_number'   => $this->generatePayslipNumber($item),
                'issue_date'       => now()->toDateString(),
                'gross_amount'     => $item->gross_amount,
                'total_earnings'   => $item->total_earnings,
                'total_deductions' => $item->total_deductions,
                'net_amount'       => $item->net_amount,
                'currency'         => $item->currency,
                'status'           => 'generated',
            ]
        );

        $pdfPath = $this->renderPdf($payslip, $item);

        $payslip->update([
            'pdf_url' => $pdfPath,
        ]);

        return $payslip->fresh();
    }

    /**
     * Render PDF to private storage and return relative path.
     */
    protected function renderPdf(Payslip $payslip, PayrollItem $item): string
    {
        $employee = $item->employee()->with('company')->first();
        $company  = $employee->company;
        $details  = $item->details()->orderBy('sort_order')->get();

        $data = [
            'company'  => $company,
            'employee' => $employee,
            'payslip'  => $payslip,
            'item'     => $item,
            'details'  => $details,
        ];

        $pdf = PDF::loadView('payslips.pdf', $data)->setPaper('A4');

        $fileName = sprintf(
            '%s/%s-%s.pdf',
            $company->id,
            $payslip->payslip_number,
            Str::uuid()
        );

        // Store in private payslips disk
        Storage::disk('payslips')->put($fileName, $pdf->output());

        return $fileName;
    }

    /**
     * Generate a readable payslip number.
     */
    protected function generatePayslipNumber(PayrollItem $item): string
    {
        return sprintf(
            'PS-%s-%s-%s',
            $item->payroll_run_id,
            $item->employee_id,
            now()->format('Ym')
        );
    }

    /**
     * Email payslips to all employees in a run.
     */
    public function emailForRun(PayrollRun $run): void
    {
        $payslips = Payslip::query()
            ->where('company_id', $run->company_id)
            ->where('payroll_run_id', $run->id)
            ->with(['employee.user'])
            ->get();

        foreach ($payslips as $payslip) {
            $this->emailPayslip($payslip);
        }

        $run->payslips()->update(['status' => 'sent']);
    }

    /**
     * Email a single payslip to the employee.
     */
    public function emailPayslip(Payslip $payslip): void
    {
        $employee = $payslip->employee()->with('user')->first();
        $email    = $employee?->email ?? $employee?->user?->email;

        if (! $email || ! $payslip->pdf_url) {
            return;
        }

        Mail::to($email)->queue(new \App\Mail\PayslipMail($payslip));
    }
}

