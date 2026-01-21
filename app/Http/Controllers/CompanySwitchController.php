<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Tenancy\CurrentCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CompanySwitchController extends Controller
{
    /**
     * Show the company switcher interface.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get all companies the user belongs to
        $companies = $user->companies()
            ->where('company_user.status', 'active')
            ->orderBy('companies.name')
            ->get();

        $currentCompany = app(CurrentCompany::class)->get();

        return view('companies.switch', compact('companies', 'currentCompany'));
    }

    /**
     * Switch to a different company.
     */
    public function switch(Request $request, Company $company)
    {
        $user = Auth::user();

        // Verify user has access to this company
        if (! $user->companies()->where('companies.id', $company->id)->exists()) {
            abort(403, 'You do not have access to this company');
        }

        // Verify company is active
        if (! $company->is_active) {
            return redirect()->back()
                ->with('error', 'This company account is inactive');
        }

        // Store selected company in session
        $sessionKey = config('tenancy.session_key', 'current_company_id');
        Session::put($sessionKey, $company->id);

        // Update current company in container
        $currentCompany = app(CurrentCompany::class);
        $currentCompany->set($company);

        // Log the switch for audit
        \App\Models\AuditLog::create([
            'company_id'  => $company->id,
            'user_id'     => $user->id,
            'event_type'  => 'company_switched',
            'description' => sprintf('Switched to company "%s" (ID: %s)', $company->name, $company->id),
            'ip_address'  => $request->ip(),
            'user_agent'  => $request->userAgent(),
            'entity_type' => Company::class,
            'entity_id'   => $company->id,
        ]);

        // Redirect to dashboard or return to previous page
        $redirectTo = $request->get('redirect_to');
        
        // If no redirect specified, try to redirect to company dashboard
        if (! $redirectTo) {
            try {
                $redirectTo = route('company.admin.dashboard');
            } catch (\Exception $e) {
                // Fallback to company switcher page if route doesn't exist
                $redirectTo = route('companies.switch.index');
            }
        }

        return redirect($redirectTo)
            ->with('success', sprintf('Switched to %s', $company->name));
    }

    /**
     * Clear the selected company (switch back to no company context).
     */
    public function clear(Request $request)
    {
        $sessionKey = config('tenancy.session_key', 'current_company_id');
        Session::forget($sessionKey);

        $currentCompany = app(CurrentCompany::class);
        $currentCompany->clear();

        return redirect()->route('home')
            ->with('success', 'Company context cleared');
    }

    /**
     * Get user's companies as JSON (for AJAX requests).
     */
    public function list()
    {
        $user = Auth::user();

        $companies = $user->companies()
            ->where('company_user.status', 'active')
            ->orderBy('companies.name')
            ->get(['companies.id', 'companies.name', 'companies.slug']);

        $currentCompany = app(CurrentCompany::class)->get();

        return response()->json([
            'companies' => $companies->map(function ($company) use ($currentCompany) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'slug' => $company->slug,
                    'is_current' => $currentCompany && $currentCompany->id() === $company->id,
                ];
            }),
            'current_company_id' => $currentCompany?->id,
        ]);
    }
}
