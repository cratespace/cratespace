<?php

namespace App\Observers;

use App\Models\Space;
use App\Observers\Traits\GeneratesHashids;

class SpaceObserver
{
    use GeneratesHashids;

    /**
     * Handle the space "creating" event.
     *
     * @param \App\Models\Space $space
     *
     * @return void
     */
    public function creating(Space $space)
    {
        $this->generateHashCode($space);
    }
}
