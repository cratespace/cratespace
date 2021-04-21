<?php

namespace App\Support;

use App\Models\User;

trait HasUser
{
    /**
     * Get the user instance.
     *
     * @return \App\Models\User
     */
    public function user(): User
    {
        return $this->user;
    }
}
