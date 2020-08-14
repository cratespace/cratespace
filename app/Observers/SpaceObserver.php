<?php

namespace App\Observers;

use App\Models\Space;
use App\Support\HashidsCodeGenerator;

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
        $space->code = $space->code ?? $this->generateHashCode($space);
    }

    /**
     * Generate unique identification code for given space.
     *
     * @param \App\Models\Space
     *
     * @return string
     */
    protected function generateHashCode(Space $space): string
    {
        $hashCodeGenerator = new HashidsCodeGenerator();
        $hashCodeGenerator->setOptions([
            'salt' => config('app.key'),
            'id' => $space->id,
        ]);

        return $hashCodeGenerator->generate();
    }
}
