<?php

namespace App\Auth\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Contracts\Auth\DeletesUsers;

class DeleteUser implements DeletesUsers
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
            $this->deleteUserResources($user);

            $this->deleteUserSupportThreads($user);

            $this->deleteUserProfiles($user);

            $user->delete();
        });
    }

    /**
     * Delete all resources that belong to the user.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    protected function deleteUserResources(User $user): void
    {
        DB::transaction(function () use ($user) {
            $user->orders->each(function ($order) {
                $order->charge()->delete();
            });

            $user->orders()->delete();

            $user->spaces()->delete();
        });
    }

    /**
     * Delete user support thread conversations.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    protected function deleteUserSupportThreads(User $user): void
    {
        DB::transaction(function () use ($user) {
            $user->tickets()->each(function ($ticket) {
                $ticket->replies()->delete();
            });
        });
    }

    /**
     * Delete user profile details.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    protected function deleteUserProfiles(User $user): void
    {
        $user->business()->delete();

        $user->account()->delete();

        $user->deleteProfilePhoto();
    }
}
