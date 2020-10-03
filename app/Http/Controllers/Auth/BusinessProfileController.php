<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessRequest;
use App\Contracts\Auth\UpdatesUserProfile;

class BusinessProfileController extends Controller
{
    /**
     * Instance of user profile manager.
     *
     * @var \App\Contracts\Auth\UpdatesUserProfile
     */
    protected $updater;

    /**
     * Create new instance 0f user profile controller.
     *
     * @param \App\Contracts\Auth\UpdatesUserProfile $updater
     */
    public function __construct(UpdatesUserProfile $updater)
    {
        $this->updater = $updater;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Contracts\Auth\UpdatesUserProfile $updater
     * @param \App\Http\Requests\BusinessRequest     $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, BusinessRequest $request)
    {
        $this->updater->update($user, $request->validated());

        if ($request->wantsJson()) {
            return response($user->fresh(), 201);
        }

        return $this->success(url()->previous());
    }
}
