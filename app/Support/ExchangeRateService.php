<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

class ExchangeRateService
{
    /**
     * Get an exchange rate between two ISO currencies.
     *
     * This is intentionally simple and expects that some external process
     * or scheduled job is seeding the "exchange_rates" cache/store.
     */
    public function getRate(string $fromCurrency, string $toCurrency, ?string $date = null): float
    {
        $fromCurrency = strtoupper($fromCurrency);
        $toCurrency   = strtoupper($toCurrency);
        $dateKey      = $date ?: now()->toDateString();

        if ($fromCurrency === $toCurrency) {
            return 1.0;
        }

        $rates = Cache::get("exchange_rates:{$dateKey}:{$fromCurrency}", []);

        if (isset($rates[$toCurrency])) {
            return (float) $rates[$toCurrency];
        }

        throw new \RuntimeException("Missing exchange rate from {$fromCurrency} to {$toCurrency} for {$dateKey}");
    }

    public function convert(Money $money, string $targetCurrency, ?string $date = null): Money
    {
        $rate = $this->getRate($money->currency, $targetCurrency, $date);

        $convertedMinor = (int) round($money->amountInMinor * $rate);

        return new Money($convertedMinor, strtoupper($targetCurrency));
    }
}

