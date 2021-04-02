<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Contracts\Actions\SecuresUserAccounts;

class UnlockUserAccount implements SecuresUserAccounts
{
    /**
     * Unlock user's account.
     *
     * @param \App\Models\User $user
     *
     * @return int
     */
    public function unlock(User $user): int
    {
        $user->update(['locked' => false]);

        return SecuresUserAccounts::UNLOCKED;
    }
}
