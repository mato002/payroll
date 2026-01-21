<?php

namespace App\Notifications;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEmployeeAddedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Employee $employee
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $company = $this->employee->company;

        return (new MailMessage)
            ->subject('New employee added to ' . $company->name)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A new employee has been added to ' . $company->name . '.')
            ->line('Name: ' . $this->employee->first_name . ' ' . $this->employee->last_name)
            ->line('Employee Code: ' . $this->employee->employee_code)
            ->action('View Employees', url()->route('company.admin.dashboard', ['company' => $company->slug]))
            ->line('This is an automated notification.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'     => 'new_employee_added',
            'employee' => [
                'id'            => $this->employee->id,
                'employee_code' => $this->employee->employee_code,
                'first_name'    => $this->employee->first_name,
                'last_name'     => $this->employee->last_name,
            ],
        ];
    }
}

