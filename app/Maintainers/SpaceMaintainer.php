<?php

namespace App\Maintainers;

use Carbon\Carbon;
use App\Contracts\Resources\Maintainer as MaintainerContract;

class SpaceMaintainer extends Maintainer implements MaintainerContract
{
    /**
     * Run the maintenance routine.
     *
     * @return void
     */
    public function runMaintenance(): void
    {
        $this->updateSpaceStatus();
    }

    /**
     * Determine if space departure date has passed and update status accordingly.
     *
     * @return void
     */
    protected function updateSpaceStatus(): void
    {
        $this->getResource('spaces')
            ->where('departs_at', '<=', Carbon::now())
            ->update(['status' => 'Expired']);
    }
}
