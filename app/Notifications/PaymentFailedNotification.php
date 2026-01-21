<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentFailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Subscription $subscription,
        protected ?string $reason = null
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $company = $this->subscription->company;

        $mail = (new MailMessage)
            ->subject('Payment failed for ' . $company->name)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A payment attempt for the subscription of ' . $company->name . ' has failed.')
            ->line('Plan: ' . $this->subscription->plan_code);

        if ($this->reason) {
            $mail->line('Reason: ' . $this->reason);
        }

        return $mail
            ->action('Update Billing Details', url()->route('billing.subscribe', ['company' => $company->slug]))
            ->line('Please update your payment method to avoid suspension.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'         => 'payment_failed',
            'subscription' => [
                'id'        => $this->subscription->id,
                'plan_code' => $this->subscription->plan_code,
                'status'    => $this->subscription->status,
            ],
            'reason'       => $this->reason,
        ];
    }
}

