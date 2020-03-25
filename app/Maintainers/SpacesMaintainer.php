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

            $this->order($space);
        });
    }

    /**
     * Determine availability by expiration date.
     *
     * @param \App\Models\Space $space
     */
    protected function expire(Space $space)
    {
        if ($space->departed()) {
            $space->markAs('Expired');
        }
    }

    /**
     * Determine availability by customer purchase.
     *
     * @param \App\Models\Space $space
     */
    protected function order(Space $space)
    {
        if ($space->ordered()) {
            $space->placeOrder();
        }
    }
}
