<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Jobs\DeleteUserJob;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteUserRequest;
use App\Contracts\Auth\UpdatesUserProfiles;
use Illuminate\Contracts\Auth\StatefulGuard;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UpdateUserProfileRequest;

class UserPofileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(User $user): View
    {
        return view('auth.profile.edit', [
            'user' => $user,
            'sessions' => $user->sessions($request)->all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateUserProfileRequest $request
     * @param \App\Models\User                            $user
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(
        UpdateUserProfileRequest $request,
        UpdatesUserProfiles $updator,
        User $user
    ): Response {
        $updator->update($user, $request->validated());

        return $request->wantsJson()
            ? response()->json('', 200)
            : back()->with('status', trans('profile-updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Http\Requests\DeleteUserRequest     $request
     * @param \App\Auth\Contracts\DeletesUsers         $deletor
     * @param \Illuminate\Contracts\Auth\StatefulGuard $auth
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy(DeleteUserRequest $request, StatefulGuard $auth): Response
    {
        DeleteUserJob::dispatch($request->user());

        $auth->logout();

        return $request->wantsJson()
            ? response()->json('', 204)
            : redirect('/');
    }
}
