<?php

namespace App\Observers;

use App\Models\Space;
use App\Observers\Traits\GeneratesHashids;

class SpaceObserver
{
    use GeneratesHashids;

    /**
     * Handle the space "created" event.
     *
     * @param \App\Models\Space $space
     *
     * @return void
     */
    public function created(Space $space)
    {
        $this->generateHashCode($space);
    }
}
