<?php

namespace App\Observers;

use App\Models\Space;
use Illuminate\Support\Facades\Auth;

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
        $space->base = $space->base ?? Auth::user()->business->country();
    }

    /**
     * Handle the Space "updating" event.
     *
     * @param \App\Models\Space $space
     *
     * @return void
     */
    public function updating(Space $space): void
    {
    }
}
