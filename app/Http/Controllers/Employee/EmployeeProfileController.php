<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EmployeeProfileController extends Controller
{
    /**
     * Show the employee profile page.
     */
    public function show(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (! $employee) {
            abort(404, 'Employee record not found for this user.');
        }

        return view('employee.profile', [
            'user'     => $user,
            'employee' => $employee,
        ]);
    }

    /**
     * Update the employee profile (limited fields).
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (! $employee) {
            abort(404, 'Employee record not found for this user.');
        }

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);

        $user->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ]);

        return redirect()
            ->route('employee.profile.show', ['company' => currentCompany()?->slug])
            ->with('status', 'Profile updated successfully.');
    }
}
