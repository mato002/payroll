<?php

namespace App\Exceptions\Payroll;

use Exception;

class MissingSalaryDataException extends Exception
{
    public function __construct(int $employeeId, string $message = 'Missing salary data')
    {
        parent::__construct("Employee #{$employeeId}: {$message}");
    }
}

