<?php

namespace App\Observers;

use App\Models\Space;
use App\Support\UidGenerator;

class SpaceObserver
{
    /**
     * Handle the space "creating" event.
     *
     * @param \App\Models\Space $space
     *
     * @return void
     */
    public function creating(Space $space)
    {
        $space->uid = $space->uid ?? $this->generateUid();
    }

    /**
     * Generate unique identification number for given space.
     *
     * @return string
     */
    protected function generateUid(): string
    {
        $generator = new UidGenerator();

        $generator->setOptions([
            'type' => 'humanUuid',
            'parameters' => null,
        ]);

        return $generator->generate();
    }
}
