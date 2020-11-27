<?php

namespace App\Actions\Fortify;

use Throwable;
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
        dispatch(function () use ($user) {
            $this->executeDeletionProcess($user);
        })->catch(function (Throwable $e) use ($user) {
            app('log')->error($e->getMessage(), [
                'user' => $user,
            ]);
        });
    }

    /**
     * Perform user entity deletion process.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    protected function executeDeletionProcess(User $user): void
    {
        DB::transaction(function () use ($user) {
            tap($user, function (User $user) {
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
        // $user->business()->delete();

        // $user->account()->delete();

        $user->deleteProfilePhoto();
    }
}
