<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use App\Jobs\DeleteUserJob;
use App\Http\Controllers\Controller;
use Inertia\Response as InertiaResponse;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Contracts\Actions\UpdatesUserProfiles;
use App\Http\Responses\Auth\DeleteUserResponse;
use App\Http\Requests\Auth\UpdateUserProfileRequest;
use App\Http\Responses\Auth\UpdateUserProfileResponse;
use Cratespace\Sentinel\Http\Requests\DeleteUserRequest;

class UserProfileController extends Controller
{
    /**
     * Show user profile view.
     *
     * @param \Illuminate\Http\Request                              $request
     * @param \Sentinel\Contracts\Responses\UserProfileViewResponse $response
     *
     * @return \Inertia\InertiaResponse
     */
    public function show(): InertiaResponse
    {
        return Inertia::render('Profile/Show');
    }

    /**
     * Update the user's profile information.
     *
     * @param \App\Http\Requests\Auth\UpdateUserProfileRequest $request
     * @param \App\Contracts\Actions\UpdatesUserProfiles       $updater
     *
     * @return mixed
     */
    public function update(UpdateUserProfileRequest $request, UpdatesUserProfiles $updater)
    {
        $updater->update($request->user(), $request->validated());

        return UpdateUserProfileResponse::dispatch();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Http\Requests\DeleteUserRequest     $request
     * @param \App\Auth\Contracts\DeletesUsers         $deletor
     * @param \Illuminate\Contracts\Auth\StatefulGuard $guard
     *
     * @return mixed
     */
    public function destroy(DeleteUserRequest $request, StatefulGuard $guard)
    {
        DeleteUserJob::dispatch($request->user()->fresh());

        $guard->logout();

        return DeleteUserResponse::dispatch();
    }
}
