<?php

namespace App\Services\Reporting;

use App\Models\Company;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

abstract class BaseReport
{
    protected Company $company;
    protected CarbonPeriod $period;
    protected ?Carbon $periodStart;
    protected ?Carbon $periodEnd;

    public function __construct(Company $company, ?Carbon $periodStart = null, ?Carbon $periodEnd = null)
    {
        $this->company = $company;
        $this->periodStart = $periodStart;
        $this->periodEnd = $periodEnd;

        if ($periodStart && $periodEnd) {
            $this->period = CarbonPeriod::create($periodStart, $periodEnd);
        }
    }

    /**
     * Build and return the report data as a collection.
     */
    abstract public function toCollection(): Collection;

    /**
     * Build and return the report data as an array.
     */
    public function toArray(): array
    {
        return $this->toCollection()->toArray();
    }

    /**
     * Get the report title.
     */
    abstract public function getTitle(): string;

    /**
     * Get the report description.
     */
    public function getDescription(): string
    {
        $period = $this->periodStart && $this->periodEnd
            ? sprintf('%s to %s', $this->periodStart->format('M d, Y'), $this->periodEnd->format('M d, Y'))
            : 'All Time';

        return sprintf('%s for %s (%s)', $this->getTitle(), $this->company->name, $period);
    }

    /**
     * Get the company instance.
     */
    protected function getCompany(): Company
    {
        return $this->company;
    }

    /**
     * Get the period start date.
     */
    protected function getPeriodStart(): ?Carbon
    {
        return $this->periodStart;
    }

    /**
     * Get the period end date.
     */
    protected function getPeriodEnd(): ?Carbon
    {
        return $this->periodEnd;
    }
}
