<?php

namespace App\Contracts\Support;

interface Cancellable
{
    /**
     * Cancel the action.
     *
     * @return void
     */
    public function cancel(): void;
}
