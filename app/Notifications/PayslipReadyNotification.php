<?php

namespace App\Notifications;

use App\Models\Payslip;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PayslipReadyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Payslip $payslip
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your payslip is ready')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your payslip for ' . $this->payslip->issue_date->format('F Y') . ' is now available.')
            ->action('View Payslip', url()->route('employee.payslips.index', ['company' => $this->payslip->company->slug]))
            ->line('This is an automated notification.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'payslip_ready',
            'payslip' => [
                'id'         => $this->payslip->id,
                'issue_date' => $this->payslip->issue_date->toDateString(),
                'net_amount' => $this->payslip->net_amount,
                'currency'   => $this->payslip->currency,
            ],
        ];
    }
}

