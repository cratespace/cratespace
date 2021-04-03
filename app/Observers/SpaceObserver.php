<?php

namespace App\Observers;

use App\Models\Space;
use App\Products\Manifest;

class SpaceObserver
{
    /**
     * Create new instance of SpaceObserver.
     *
     * @param \App\Products\Manifest $manifest
     *
     * @return void
     */
    public function __construct(Manifest $manifest)
    {
        $this->manifest = $manifest;
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
        $this->manifest->store($space);
    }
}
