<?php

namespace App\Support;

use Carbon\CarbonInterface;

class Formatting
{
    public static function money(float|string $amount, string $currency): string
    {
        $money = Money::fromDecimal($amount, $currency);

        return $money->format();
    }

    public static function localizedDate(
        CarbonInterface|\DateTimeInterface|string|null $date,
        ?string $format = null,
        ?string $locale = null
    ): ?string {
        if (! $date) {
            return null;
        }

        $locale ??= app()->getLocale() ?: 'en';

        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        } else {
            $date = \Carbon\Carbon::instance($date);
        }

        $date->locale($locale);

        if ($format) {
            return $date->translatedFormat($format);
        }

        // Default to a medium, locale-aware format like "21 Jan 2026"
        return $date->translatedFormat('d M Y');
    }
}

