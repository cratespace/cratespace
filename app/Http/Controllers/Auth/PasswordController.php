<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Contracts\Auth\UpdatesUserPasswords;
use App\Http\Requests\UpdatePasswordRequest;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     *
     * @param \Illuminate\Http\Request                        $request
     * @param \Laravel\Fortify\Contracts\UpdatesUserPasswords $updater
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePasswordRequest $request, UpdatesUserPasswords $updater)
    {
        $updater->update($request->user(), $request->validated());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'password-updated');
    }
}
