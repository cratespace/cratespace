<?php

namespace App\Auth\Actions;

use App\Models\User;
use App\Contracts\Auth\ResetsUserPasswords;
use App\Auth\Actions\Traits\UpdatesPassword;

class ResetUserPassword implements ResetsUserPasswords
{
    use UpdatesPassword;

    /**
     * Validate and reset the user's forgotten password.
     *
     * @param \App\Models\User $user
     * @param array            $data
     *
     * @return void
     */
    public function reset(User $user, array $data): void
    {
        $this->updatePassword($user, $data['password']);
    }
}
