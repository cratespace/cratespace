<?php

namespace App\Resources\Spaces;

use App\Models\Space;
use App\Resources\Contracts\Maintainer as MaintainerContract;

class SpacesMaintainer implements MaintainerContract
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
