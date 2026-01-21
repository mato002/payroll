<?php

namespace App\Exceptions\Payroll;

use Exception;

class InvalidTaxConfigurationException extends Exception
{
    public function __construct(string $countryCode, string $message = 'Invalid tax configuration')
    {
        parent::__construct("Country {$countryCode}: {$message}");
    }
}

