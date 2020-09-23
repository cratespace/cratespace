<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Contracts\Auth\DeletesUsers;
use App\Http\Controllers\Controller;
use App\Contracts\Auth\UpdatesUserProfile;
use Illuminate\Contracts\Auth\StatefulGuard;

class ProfileController extends Controller
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
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User         $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        $this->authorize('manage', $user = user());

        return view('auth.users.edit', [
            'user' => $user->load('business'),
            'sessions' => $user->sessions($request),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Contracts\Auth\UpdatesUserProfile $updater
     * @param \Illuminate\Http\Request               $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UserRequest $request)
    {
        $this->updater->update($user, $request->validated());

        if ($request->wantsJson()) {
            return response($user->fresh(), 201);
        }

        return $this->success(url()->previous());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Contracts\Auth\DeletesUsers         $deletor
     * @param \App\Models\User                         $user
     * @param \Illuminate\Contracts\Auth\StatefulGuard $auth
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeletesUsers $deletor, User $user, StatefulGuard $auth)
    {
        $deletor->delete($user->fresh());

        $auth->logout();

        return redirect('/', 409);
    }
}
