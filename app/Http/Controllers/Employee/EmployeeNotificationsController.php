<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeNotificationsController extends Controller
{
    /**
     * Show all notifications for the employee.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $notifications = $user->notifications()
            ->orderByDesc('created_at')
            ->paginate(20);

        // Mark as read when viewing
        $user->unreadNotifications->markAsRead();

        return view('employee.notifications', [
            'notifications' => $notifications,
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Request $request, string $id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return redirect()
            ->route('employee.notifications.index', ['company' => currentCompany()?->slug])
            ->with('status', 'All notifications marked as read.');
    }
}
