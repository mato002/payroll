<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Base Domain for Tenant Subdomains
    |--------------------------------------------------------------------------
    |
    | This is the base domain used for tenant subdomains.
    | Example: if base_domain is "app.test", tenant URLs will look like:
    | "companyA.app.test", "companyB.app.test", etc.
    |
    */

    'base_domain' => env('TENANCY_BASE_DOMAIN', 'app.test'),

    /*
    |--------------------------------------------------------------------------
    | Company Detection Methods
    |--------------------------------------------------------------------------
    |
    | Define the order of methods to detect the current company.
    | Available methods: 'subdomain', 'header', 'session', 'domain'
    |
    */

    'detection_methods' => [
        'subdomain',
        'header',
        'session',
    ],

    /*
    |--------------------------------------------------------------------------
    | Company Identifier Header Name
    |--------------------------------------------------------------------------
    |
    | The HTTP header name used to identify the company when using header detection.
    | Example: X-Company-Slug or X-Tenant-ID
    |
    */

    'header_name' => env('TENANCY_HEADER_NAME', 'X-Company-Slug'),

    /*
    |--------------------------------------------------------------------------
    | Session Key for Company
    |--------------------------------------------------------------------------
    |
    | The session key used to store the current company identifier.
    |
    */

    'session_key' => env('TENANCY_SESSION_KEY', 'current_company_id'),

    /*
    |--------------------------------------------------------------------------
    | Require Company for All Routes
    |--------------------------------------------------------------------------
    |
    | If true, all routes will require a company to be resolved.
    | If false, routes without a company context will be allowed (e.g., public routes).
    |
    */

    'require_company' => env('TENANCY_REQUIRE_COMPANY', false),

    /*
    |--------------------------------------------------------------------------
    | Allow Super Admin to Bypass Company Scope
    |--------------------------------------------------------------------------
    |
    | If true, super admins can access data across all companies.
    | If false, even super admins are scoped to a company.
    |
    */

    'super_admin_bypass' => env('TENANCY_SUPER_ADMIN_BYPASS', true),
];

