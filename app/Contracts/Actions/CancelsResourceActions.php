<?php

namespace App\Contracts\Actions;

use App\Support\Resource;

interface CancelsResourceActions
{
    /**
     * Cancel resource action.
     *
     * @param \App\Support\Resource $resource
     *
     * @return void
     */
    public function cancel(Resource $resource): void;
}
