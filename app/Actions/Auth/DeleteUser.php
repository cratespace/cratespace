<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Contracts\Actions\DeletesUsers;

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
        DB::transaction(function () use ($user): void {
            tap($user, function (User $user): void {
                $this->deleteUserResources($user);

                $this->deleteUserProfiles($user);
            })->delete();
        }, 2);
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
        optional($user->invitation)->delete();

        $user->orders->each(fn ($order) => $order->delete());

        $user->spaces->each(fn ($space) => $space->delete());
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
        $user->deleteProfilePhoto();

        optional($user->profile)->delete();

        $user->tokens->each->delete();
    }
}
