<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Handle contact form submission from the marketing site.
     */
    public function submit(Request $request)
    {
        $data = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'company'   => ['nullable', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255'],
            'employees' => ['nullable', 'string', 'max:50'],
            'topic'     => ['required', 'string', 'max:50'],
            'message'   => ['required', 'string', 'max:5000'],
            'consent'   => ['nullable', 'accepted'],
        ]);

        // Basic example: log the inquiry and send a simple email to the default address.
        Log::info('Marketing contact inquiry received', $data);

        $to = config('mail.from.address');

        if ($to) {
            try {
                Mail::raw(
                    "New contact inquiry\n\n"
                    . "Name: {$data['name']}\n"
                    . "Company: " . ($data['company'] ?? '-') . "\n"
                    . "Email: {$data['email']}\n"
                    . "Employees: " . ($data['employees'] ?? '-') . "\n"
                    . "Topic: {$data['topic']}\n"
                    . "Consent to marketing: " . (!empty($data['consent']) ? 'Yes' : 'No') . "\n\n"
                    . "Message:\n{$data['message']}",
                    function ($message) use ($to) {
                        $message->to($to)
                            ->subject('New contact inquiry from marketing site');
                    }
                );
            } catch (\Throwable $e) {
                Log::error('Failed to send contact inquiry email', [
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return back()->with('status', 'Thanks for reaching out. We’ll be in touch shortly.');
    }
}

