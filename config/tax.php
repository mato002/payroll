<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Country-specific Income Tax Rules
    |--------------------------------------------------------------------------
    |
    | Very simple example of progressive tax brackets per country.
    | You can adjust these values to match real tax regulations.
    |
    */

    'countries' => [
        // Example: United States (dummy values)
        'US' => [
            'brackets' => [
                ['from' => 0, 'to' => 1000, 'rate' => 0],    // 0% on first 1,000
                ['from' => 1000, 'to' => 3000, 'rate' => 10], // 10% between 1,000 - 3,000
                ['from' => 3000, 'to' => null, 'rate' => 20], // 20% above 3,000
            ],
        ],

        // Example: United Kingdom (dummy values)
        'GB' => [
            'brackets' => [
                ['from' => 0, 'to' => 1250, 'rate' => 0],
                ['from' => 1250, 'to' => 5000, 'rate' => 20],
                ['from' => 5000, 'to' => null, 'rate' => 40],
            ],
        ],

        // Fallback: flat 10% tax for any other country (override in .env if needed)
        'DEFAULT' => [
            'brackets' => [
                ['from' => 0, 'to' => null, 'rate' => 10],
            ],
        ],
    ],
];

