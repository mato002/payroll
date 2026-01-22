<?php

namespace App\Http\Middleware;

use App\Tenancy\CurrentCompany;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(401);
        }

        // Super admin bypass: always allow when flagged, regardless of requested role
        if (property_exists($user, 'is_super_admin') || array_key_exists('is_super_admin', $user->getAttributes())) {
            if ($user->is_super_admin) {
                return $next($request);
            }
        }

        // Check if we have a current company context (for company-specific roles)
        $currentCompany = app(CurrentCompany::class)->get();
        
        if ($currentCompany) {
            // Check company-specific roles
            $hasRole = false;
            foreach ($roles as $role) {
                if ($user->hasRoleInCompany($role, $currentCompany->id)) {
                    $hasRole = true;
                    break;
                }
            }
            
            // Also check if user is owner of the company (owners have all permissions)
            if (!$hasRole && $user->companies()->where('companies.id', $currentCompany->id)->wherePivot('is_owner', true)->exists()) {
                $hasRole = true;
            }
            
            if (!$hasRole) {
                abort(403, 'You do not have permission to access this resource.');
            }
        } else {
            // No company context - check global role property (for super admin routes)
            // This is a fallback for routes that don't require company context
            if (property_exists($user, 'role') && !in_array($user->role, $roles, true)) {
                abort(403, 'You do not have permission to access this resource.');
            }
        }

        return $next($request);
    }
}

