<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Contracts\Actions\SecuresUserAccounts;

class LockUserAccount implements SecuresUserAccounts
{
    /**
     * Lock user's account.
     *
     * @param \App\Models\User $user
     *
     * @return int
     */
    public function lock(User $user): int
    {
        $user->update(['locked' => true]);

        return SecuresUserAccounts::LOCKED;
    }
}
