<?php

namespace App\Contracts\Auth;

use Illuminate\Http\Request;

interface AuthenticatesUsers
{
    /**
     * Authenticate given login request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function authenticate(Request $request);
}
