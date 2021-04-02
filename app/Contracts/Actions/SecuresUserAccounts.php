<?php

namespace App\Contracts\Actions;

interface SecuresUserAccounts
{
    /**
     * Indicate if the user account has successfully been locked.
     */
    public const LOCKED = 1;

    /**
     * Indicate if the user account has successfully been unlocked.
     */
    public const UNLOCKED = 0;
}
