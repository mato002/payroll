<?php

namespace App\Support;

use NumberFormatter;

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
        $locale ??= app()->getLocale() ?: 'en';

        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);

        return $formatter->formatCurrency($this->amountInMinor / 100, $this->currency);
    }
}

