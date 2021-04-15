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
    public function creating(Space $space): void
    {
        $space->base = $space->base ?? $space->owner->address->country;
    }

    /**
     * Handle the Space "created" event.
     *
     * @param \App\Models\Space $space
     *
     * @return void
     */
    public function created(Space $space): void
    {
        $space->product()->create(['code' => $space->code]);
    }
}
