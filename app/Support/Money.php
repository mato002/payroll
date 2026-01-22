<?php

namespace App\Support;

class Money
{
    public function __construct(
        public readonly int $amountInMinor,
        public readonly string $currency
    ) {
    }

    public static function fromDecimal(string|float $amount, string $currency): self
    {
        $minor = (int) round(((float) $amount) * 100);

        return new self($minor, $currency);
    }

    public function toDecimal(): string
    {
        return number_format($this->amountInMinor / 100, 2, '.', '');
    }

    public function format(?string $locale = null): string
    {
        // Check if intl extension is available
        if (extension_loaded('intl') && class_exists(\NumberFormatter::class)) {
            $locale ??= app()->getLocale() ?: 'en';
            
            try {
                $formatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
                return $formatter->formatCurrency($this->amountInMinor / 100, $this->currency);
            } catch (\Exception $e) {
                // Fall through to fallback formatting
            }
        }

        // Fallback: simple currency formatting without intl extension
        $amount = $this->amountInMinor / 100;
        $formatted = number_format($amount, 2, '.', ',');
        
        // Add currency symbol based on common currencies
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'JPY' => '¥',
            'INR' => '₹',
            'NGN' => '₦',
            'KES' => 'KSh',
            'ZAR' => 'R',
        ];
        
        $symbol = $symbols[strtoupper($this->currency)] ?? strtoupper($this->currency) . ' ';
        
        return $symbol . $formatted;
    }
}

