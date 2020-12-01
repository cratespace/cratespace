<?php

namespace App\Contracts\Auth;

use Illuminate\Http\Request;

interface Authenticator
{
    /**
     * Authenticate given login request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function authenticate(Request $request): void;
}
