<?php

namespace App\Notifications;

use App\Models\PayrollRun;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PayrollCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected PayrollRun $run
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Payroll Completed: ' . $this->run->name)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('The payroll "' . $this->run->name . '" has been approved and locked.')
            ->line('Pay date: ' . $this->run->pay_date?->format('Y-m-d'))
            ->line('Total net amount: ' . $this->run->total_net_amount)
            ->action('View Payroll', url()->route('company.admin.dashboard', ['company' => $this->run->company->slug]))
            ->line('This is an automated notification.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'        => 'payroll_completed',
            'payroll_run' => [
                'id'    => $this->run->id,
                'name'  => $this->run->name,
                'pay_date' => optional($this->run->pay_date)->toDateString(),
            ],
        ];
    }
}

