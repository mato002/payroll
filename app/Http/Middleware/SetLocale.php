<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Set the application locale (and optionally timezone) based on
     * the authenticated user and/or current company.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->determineLocale($request);

        if ($locale) {
            app()->setLocale($locale);
        }

        if ($timezone = $this->determineTimezone($request)) {
            config(['app.timezone' => $timezone]);
            date_default_timezone_set($timezone);
        }

        return $next($request);
    }

    protected function determineLocale(Request $request): ?string
    {
        // 1. Explicit ?lang=xx on the request
        if ($lang = $request->query('lang')) {
            return $lang;
        }

        // 2. Authenticated user preference (if such a column exists)
        $user = $request->user();
        if ($user && isset($user->locale) && $user->locale) {
            return $user->locale;
        }

        // 3. Current company default (if bound by tenancy middleware)
        if (function_exists('currentCompany') && $company = currentCompany()) {
            if (isset($company->locale) && $company->locale) {
                return $company->locale;
            }
        }

        // 4. Fallback to app default
        return config('app.locale');
    }

    protected function determineTimezone(Request $request): ?string
    {
        // Prefer user-specific timezone if present
        $user = $request->user();
        if ($user && isset($user->timezone) && $user->timezone) {
            return $user->timezone;
        }

        // Otherwise fall back to company timezone if available
        if (function_exists('currentCompany') && $company = currentCompany()) {
            if (isset($company->timezone) && $company->timezone) {
                return $company->timezone;
            }
        }

        return null;
    }
}

