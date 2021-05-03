<?php

namespace App\Models\Concerns;

trait ManagesAdmin
{
    /**
     * Determine if the user is an administrator.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('Administrator');
    }
}
