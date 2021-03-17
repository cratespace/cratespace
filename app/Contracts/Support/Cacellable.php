<?php

namespace App\Contracts\Support;

interface Cacellable
{
    /**
     * Cancel action.
     *
     * @return void
     */
    public function cancel(): void;
}
