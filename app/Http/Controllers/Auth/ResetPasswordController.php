<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\UserPasswordRequest;
use App\Contracts\Auth\UpdatesUserPasswords;
use App\Http\Controllers\Auth\Concerns\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Update given user's password.
     *
     * @param \App\Contracts\Auth\UpdatesUserPasswords $updator
     * @param \App\Http\Requests\UserPasswordRequest   $request
     * @param \App\Models\User                         $user
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdatesUserPasswords $updator, UserPasswordRequest $request, User $user)
    {
        $updator->update($user, $request->validated());

        if ($request->wantsJson()) {
            return response([], 204);
        }

        return back()->with('status', 'Password updated');
    }
}
