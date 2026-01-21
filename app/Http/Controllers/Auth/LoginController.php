<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['boolean'],
        ]);

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('The provided credentials do not match our records.'),
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Super admin → platform dashboard
        if ($user->is_super_admin) {
            return redirect()->intended(route('admin.dashboard'));
        }

        // Company admin/employee → company switcher
        $companies = $user->accessibleCompanies();

        if ($companies->isEmpty()) {
            // User has no companies, redirect to landing with message
            return redirect()->route('landing')
                ->with('error', 'You do not have access to any companies. Please contact support.');
        }

        // Redirect to company switcher (user will select company and be redirected to subdomain)
        return redirect()->intended(route('companies.switch.index'));
    }

    /**
     * Handle a logout request.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
