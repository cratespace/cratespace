<?php

namespace App\Contracts\Business;

use App\Contracts\Support\Cancellable;

interface Invitation extends Cancellable
{
    /**
     * Accept this invitation.
     *
     * @return bool
     */
    public function accept(): bool;
}
