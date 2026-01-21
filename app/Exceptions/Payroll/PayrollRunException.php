<?php

namespace App\Exceptions\Payroll;

use Exception;

class PayrollRunException extends Exception
{
    public function __construct(string $message, ?int $employeeId = null)
    {
        if ($employeeId) {
            $message = "Employee #{$employeeId}: {$message}";
        }

        parent::__construct($message);
    }
}

