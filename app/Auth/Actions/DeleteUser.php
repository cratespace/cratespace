<?php

namespace App\Auth\Actions;

use Illuminate\Support\Facades\DB;

class DeleteUser
{
    /**
     * Delete the given user.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    public function delete(User $user): void
    {
        DB::transaction(function () use ($user) {
            $user->delete();
        });
    }
}
