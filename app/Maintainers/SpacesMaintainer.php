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
        $this->updateSpacesStatus();
    }

    /**
     * Update resource inventory.
     */
    protected function updateSpacesStatus()
    {
        Space::all()->map(function ($space) {
            if ($space->departed()) {
                $space->markAs('Expired');
            }
        });
    }
}
