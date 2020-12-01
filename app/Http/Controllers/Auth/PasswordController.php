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
     * @param \Illuminate\Http\Request                        $request
     * @param \Laravel\Fortify\Contracts\UpdatesUserPasswords $updater
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdatePasswordRequest $request, UpdatesUserPasswords $updater): Response
    {
        $updater->update($request->user(), $request->validated());

        return $request->wantsJson()
            ? response()->json()
            : back()->with('status', 'password-updated');
    }
}
