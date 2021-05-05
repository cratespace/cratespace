<?php

namespace App\Models\Concerns;

use App\Models\Space;

trait ManagesSpace
{
    /**
     * Boot ManagesSpace trait.
     *
     * @return void
     */
    protected static function bootManagesSpace(): void
    {
        static::creating(function (Space $space) {
            $base = $space->owner->base();

            if (is_null($space->base)) {
                $space->base = $base;
            }

            if ($space->base !== $base) {
                $space->base = $base;
            }

            $space->validateSchedule();
        });
    }
}
