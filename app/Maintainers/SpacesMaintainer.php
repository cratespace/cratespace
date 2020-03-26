<?php

namespace App\Maintainers;

use App\Models\Space;

class SpacesMaintainer extends Maintainer
{
    /**
     * Run maintenance on resource.
     */
    public function run()
    {
        $this->updateSpaceStatus();
    }

    /**
     * Update resource inventory.
     */
    protected function updateSpaceStatus()
    {
        $this->getResource()->map(function ($space) {
            $this->expire($space);
        });
    }

    /**
     * Set space status as expired if space has departed.
     *
     * @param  \App\Models\Order  $space
     */
    protected function expire(Space $space)
    {
        if (! $space->ordered() && $space->departed()) {
            $space->markAs('Expired');
        }
    }
}
