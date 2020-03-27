<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Requests\UserPassword as UserPasswordForm;

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
     * Reset user's password.
     *
     * @param  \App\Http\Requests\UserPassword $request
     * @param  \App\Models\User             $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserPasswordForm $request, User $user)
    {
        $this->resetPassword($user, $request->password);

        return $this->success(route('users.edit', compact('user')));
    }
}
