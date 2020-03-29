<?php

namespace App\Processes\Orders\Concerns;

trait IdentifiesResource
{
    /**
     * Get ordered space details.
     *
     * @return \App\Models\Space
     */
    protected function getDetails()
    {
        if (! cache()->has('space')) {
            throw new ResourceNotFoundException();
        }

        return cache('space');
    }
}
