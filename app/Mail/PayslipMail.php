<?php

namespace App\Mail;

use App\Models\Payslip;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class PayslipMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Payslip $payslip
    ) {
    }

    public function build(): self
    {
        $employee = $this->payslip->employee;
        $company  = $this->payslip->company;

        $periodEnd = $this->payslip->payrollRun?->period_end_date;
        $subject = sprintf(
            __('Your payslip for %s'),
            format_localized_date($periodEnd, 'F Y') ?? format_localized_date(now(), 'F Y')
        );

        $mail = $this->subject($subject)
            ->view('emails.payslips.default', [
                'payslip'  => $this->payslip,
                'employee' => $employee,
                'company'  => $company,
            ]);

        if ($this->payslip->pdf_url) {
            $disk = Storage::disk('payslips');
            if ($disk->exists($this->payslip->pdf_url)) {
                $mail->attachFromStorageDisk('payslips', $this->payslip->pdf_url, $this->payslip->payslip_number . '.pdf', [
                    'mime' => 'application/pdf',
                ]);
            }
        }

        return $mail;
    }
}

