<?php

namespace App\Auth\Actions;

use App\Models\User;
use App\Auth\Actions\Traits\UpdatesPassword;
use App\Contracts\Auth\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use UpdatesPassword;

    /**
     * Validate and update the user's password.
     *
     * @param \App\Models\User $user
     * @param array            $data
     *
     * @return void
     */
    public function update(User $user, array $data): void
    {
        $this->updatePassword($user, $data['password']);
    }
}
