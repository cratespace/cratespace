<?php

namespace App\Http\Controllers\Auth\Concerns;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\ConfirmPasswordRequest;

trait ConfirmsPasswords
{
    use RedirectsUsers;

    /**
     * Display the password confirmation view.
     *
     * @return \Illuminate\View\View
     */
    public function showConfirmForm()
    {
        return view('auth.passwords.confirm');
    }

    /**
     * Confirm the given user's password.
     *
     * @param \App\Http\Requests\ConfirmPasswordRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function confirm(ConfirmPasswordRequest $request)
    {
        $request->session()->put('auth.password_confirmed_at', time());

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->intended($this->redirectPath());
    }
}
