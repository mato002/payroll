<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Subscription Plan Code
    |--------------------------------------------------------------------------
    |
    | This plan code will be used when a new company signs up, unless a
    | specific plan is chosen during signup.
    |
    */

    'default_plan_code' => env('BILLING_DEFAULT_PLAN_CODE', 'starter'),

    /*
    |--------------------------------------------------------------------------
    | Grace Period (Days)
    |--------------------------------------------------------------------------
    |
    | Number of days after an invoice due date during which the company
    | still has access before being blocked by subscription middleware.
    |
    */

    'grace_days' => env('BILLING_GRACE_DAYS', 7),
];
