<?php

namespace App\Services\Payroll\Tax;

use App\Exceptions\Payroll\InvalidTaxConfigurationException;

class TaxCalculator
{
    /**
     * Calculate tax for a given taxable income and country.
     *
     * Uses a simple progressive bracket system defined in config/tax.php.
     */
    public function calculate(float $taxableIncome, string $countryCode): float
    {
        $countryCode = strtoupper($countryCode);
        $rules       = config("tax.countries.{$countryCode}")
            ?? config('tax.countries.DEFAULT');

        if (! $rules || empty($rules['brackets'])) {
            throw new InvalidTaxConfigurationException($countryCode, 'No tax brackets defined.');
        }

        foreach ($rules['brackets'] as $index => $bracket) {
            if (! isset($bracket['from'], $bracket['rate'])) {
                throw new InvalidTaxConfigurationException(
                    $countryCode,
                    "Bracket #{$index} is missing required fields."
                );
            }

            if (($bracket['to'] ?? null) !== null && $bracket['to'] < $bracket['from']) {
                throw new InvalidTaxConfigurationException(
                    $countryCode,
                    "Bracket #{$index} has to < from."
                );
            }

            if ($bracket['rate'] < 0 || $bracket['rate'] > 100) {
                throw new InvalidTaxConfigurationException(
                    $countryCode,
                    "Bracket #{$index} has invalid rate {$bracket['rate']}."
                );
            }
        }

        $tax = 0.0;

        foreach ($rules['brackets'] as $bracket) {
            $rate     = (float) ($bracket['rate'] ?? 0);
            $from     = (float) ($bracket['from'] ?? 0);
            $to       = $bracket['to'] === null ? null : (float) $bracket['to'];

            if ($taxableIncome <= $from) {
                continue;
            }

            $upperLimit = $to ?? $taxableIncome;
            $amountInBracket = min($taxableIncome, $upperLimit) - $from;

            if ($amountInBracket <= 0) {
                continue;
            }

            $tax += $amountInBracket * ($rate / 100);

            if ($to !== null && $taxableIncome <= $to) {
                break;
            }
        }

        return round($tax, 2);
    }
}

