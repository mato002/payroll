<?php

namespace App\Http\Middleware;

use App\Models\Company;
use App\Tenancy\CurrentCompany;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetCurrentCompany
{
    /**
     * Resolve the current tenant company from the request and
     * bind it into the container for global access and scoping.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $company = $this->detectCompany($request);

        if (! $company) {
            // Check if company is required
            if (config('tenancy.require_company', false)) {
                abort(404, 'Company not found or not specified');
            }

            // Allow request to proceed without company context
            return $next($request);
        }

        // Verify company is active
        if (! $company->is_active) {
            abort(403, 'Company account is inactive');
        }

        // Set the current company in the container
        /** @var \App\Tenancy\CurrentCompany $currentCompany */
        $currentCompany = app(CurrentCompany::class);
        $currentCompany->set($company);

        // Share with views
        view()->share('currentCompany', $company);

        // Verify user has access to this company (if authenticated)
        if (Auth::check() && ! $this->userHasAccessToCompany(Auth::user(), $company)) {
            abort(403, 'You do not have access to this company');
        }

        return $next($request);
    }

    /**
     * Detect company using configured detection methods.
     * Prioritizes route parameter, then session for authenticated users when no subdomain is present.
     */
    protected function detectCompany(Request $request): ?Company
    {
        // First, check if company is in the route parameter (path-based routing)
        $routeCompany = $this->detectFromRoute($request);
        if ($routeCompany) {
            return $routeCompany;
        }

        // If user is authenticated and no subdomain, prioritize session
        if (Auth::check() && ! $this->detectFromSubdomain($request)) {
            $sessionKey = config('tenancy.session_key', 'current_company_id');
            $companyId = $request->session()->get($sessionKey);
            
            if ($companyId) {
                $company = Company::find($companyId);
                if ($company && $this->userHasAccessToCompany(Auth::user(), $company)) {
                    return $company;
                }
            }
        }

        // Otherwise, use configured detection methods
        $methods = config('tenancy.detection_methods', ['subdomain', 'header', 'session']);

        foreach ($methods as $method) {
            $identifier = match ($method) {
                'subdomain' => $this->detectFromSubdomain($request),
                'header' => $this->detectFromHeader($request),
                'session' => $this->detectFromSession($request),
                'domain' => $this->detectFromDomain($request),
                default => null,
            };

            if ($identifier) {
                $company = $this->resolveCompany($identifier);
                if ($company) {
                    return $company;
                }
            }
        }

        return null;
    }

    /**
     * Extract company from route parameter (for path-based routing).
     */
    protected function detectFromRoute(Request $request): ?Company
    {
        $route = $request->route();
        if (!$route) {
            return null;
        }

        // Check if 'company' parameter exists in the route
        // Try to get it from route parameters
        $companySlug = $route->parameter('company');
        
        // If not found in parameters, try to get from the route URI segments
        if (!$companySlug) {
            $segments = $request->segments();
            // For path like /companies/{company}/admin/dashboard
            // segments would be: ['companies', 'acme-corp', 'admin', 'dashboard']
            $companiesIndex = array_search('companies', $segments);
            if ($companiesIndex !== false && isset($segments[$companiesIndex + 1])) {
                $companySlug = $segments[$companiesIndex + 1];
            }
        }
        
        if (!$companySlug) {
            return null;
        }

        // If it's already a Company model instance, return it
        if ($companySlug instanceof Company) {
            return $companySlug;
        }

        // Otherwise, resolve by slug
        return $this->resolveCompany($companySlug);
    }

    /**
     * Extract company identifier from subdomain.
     */
    protected function detectFromSubdomain(Request $request): ?string
    {
        $host = $request->getHost();
        $baseDomain = config('tenancy.base_domain', 'app.test');

        if (! str_ends_with($host, $baseDomain)) {
            return null;
        }

        $subdomain = rtrim(str_ireplace('.' . $baseDomain, '', $host), '.');

        if (empty($subdomain) || $subdomain === $baseDomain || $subdomain === $host) {
            return null;
        }

        return $subdomain;
    }

    /**
     * Extract company identifier from HTTP header.
     */
    protected function detectFromHeader(Request $request): ?string
    {
        $headerName = config('tenancy.header_name', 'X-Company-Slug');
        return $request->header($headerName);
    }

    /**
     * Extract company identifier from session.
     */
    protected function detectFromSession(Request $request): ?int
    {
        $sessionKey = config('tenancy.session_key', 'current_company_id');
        return $request->session()->get($sessionKey);
    }

    /**
     * Extract company identifier from full domain.
     */
    protected function detectFromDomain(Request $request): ?string
    {
        // For custom domains (e.g., company.com instead of company.app.com)
        $host = $request->getHost();
        return Company::where('domain', $host)->value('slug');
    }

    /**
     * Resolve company by identifier (slug or ID).
     */
    protected function resolveCompany(string|int $identifier): ?Company
    {
        if (is_numeric($identifier)) {
            return Company::find($identifier);
        }

        return Company::where('slug', $identifier)->first();
    }

    /**
     * Check if user has access to the company.
     */
    protected function userHasAccessToCompany($user, Company $company): bool
    {
        // Super admin can access all companies if bypass is enabled
        if ($user->is_super_admin && config('tenancy.super_admin_bypass', true)) {
            return true;
        }

        // Check if user is a member of this company
        return $user->companies()->where('companies.id', $company->id)->exists();
    }
}

