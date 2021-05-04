<?php

namespace App\Observers;

use App\Models\Space;

class SpaceObserver
{
    /**
     * Handle the Space "creating" event.
     *
     * @param \App\Models\Space $space
     *
     * @return void
     */
    public function creating(Space $space)
    {
        $base = $space->owner->base();

        if (is_null($space->base)) {
            $space->base = $base;
        }

        if ($space->base !== $base) {
            $space->base = $base;
        }

        $space->validateSchedule();
    }
}
