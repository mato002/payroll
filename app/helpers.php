<?php

use App\Support\Formatting;

if (! function_exists('format_money')) {
    function format_money(float|string $amount, string $currency): string
    {
        return Formatting::money($amount, $currency);
    }
}

if (! function_exists('format_localized_date')) {
    function format_localized_date(
        \Carbon\CarbonInterface|\DateTimeInterface|string|null $date,
        ?string $format = null,
        ?string $locale = null
    ): ?string {
        return Formatting::localizedDate($date, $format, $locale);
    }
}

