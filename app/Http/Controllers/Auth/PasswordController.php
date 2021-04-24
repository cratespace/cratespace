<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Contracts\Actions\UpdatesUserPasswords;
use App\Http\Requests\Auth\UpdatePasswordRequest;

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
    public function __invoke(UpdatePasswordRequest $request, UpdatesUserPasswords $updater): Response
    {
        $updater->update($request->user(), $request->all());

        return $request->wantsJson()
            ? response()->json()
            : back()->with('status', 'password-updated');
    }
}
