<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionExpiringNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Subscription $subscription
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $company = $this->subscription->company;
        $date    = $this->subscription->trial_end_date ?? $this->subscription->next_billing_date;

        return (new MailMessage)
            ->subject('Subscription expiring soon for ' . $company->name)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('The subscription for ' . $company->name . ' is expiring soon.')
            ->line('Plan: ' . $this->subscription->plan_code)
            ->line('Renewal / trial end date: ' . optional($date)->toDateString())
            ->action('Manage Billing', url()->route('billing.subscribe', ['company' => $company->slug]))
            ->line('Please update your payment information to avoid interruption.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'         => 'subscription_expiring',
            'subscription' => [
                'id'          => $this->subscription->id,
                'plan_code'   => $this->subscription->plan_code,
                'status'      => $this->subscription->status,
                'trial_end'   => optional($this->subscription->trial_end_date)->toDateString(),
                'next_billing'=> optional($this->subscription->next_billing_date)->toDateString(),
            ],
        ];
    }
}

