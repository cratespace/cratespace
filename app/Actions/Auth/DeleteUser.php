<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable;
use Cratespace\Sentinel\Contracts\Actions\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return void
     */
    public function delete(Authenticatable $user): void
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
