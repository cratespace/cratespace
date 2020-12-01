<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Contracts\Auth\UpdatesUserProfiles;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UpdateUserProfileRequest;

class UserProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(User $user): View
    {
        $this->authorize('view', $request->user());

        return view('auth.profile.edit', [
            'user' => $user,
            'sessions' => $user->sessions($request)->all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateUserProfileRequest $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(
        UpdateUserProfileRequest $request,
        UpdatesUserProfiles $updator
    ): Response {
        $this->authorize('update', $request->user());

        $updator->update($request->user(), $request->validated());

        return $request->wantsJson()
            ? response()->json('', 200)
            : back()->with('status', trans('profile-updated'));
    }
}
