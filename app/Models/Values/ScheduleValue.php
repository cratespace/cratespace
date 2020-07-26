<?php

namespace App\Models\Values;

use Carbon\Carbon;

class ScheduleValue
{
    /**
     * Departure date as string.
     *
     * @var string
     */
    public $departsAt;

    /**
     * Arrival date as string.
     *
     * @var string
     */
    public $arrivesAt;

    /**
     * Create new schedule value instance.
     *
     * @param string $departsAt
     * @param string $arrivesAt
     */
    public function __construct(string $departsAt, string $arrivesAt)
    {
        $this->departsAt = $departsAt;
        $this->arrivesAt = $arrivesAt;
    }

    /**
     * Determine if the model value is nearing departure date.
     *
     * @return bool
     */
    public function nearingDeparture(): bool
    {
        return Carbon::parse($this->departsAt)->lte(Carbon::tomorrow());
    }
}
