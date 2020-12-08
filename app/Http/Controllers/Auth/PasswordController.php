<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Contracts\Auth\UpdatesUserPasswords;
use App\Http\Requests\UpdatePasswordRequest;
use Symfony\Component\HttpFoundation\Response;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     *
     * @param \App\Http\Requests\UpdatePasswordRequest $request
     * @param \App\Contracts\Auth\UpdatesUserPasswords $updater
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdatePasswordRequest $request, UpdatesUserPasswords $updater): Response
    {
        $this->authorize('update', $request->user());

        $updater->update($request->user(), $request->all());

        return $request->wantsJson()
            ? response()->json()
            : back()->with('status', 'password-updated');
    }
}
