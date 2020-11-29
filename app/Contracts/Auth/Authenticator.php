<?php

namespace App\Contracts\Auth;

use Illuminate\Http\Request;

interface Authenticator
{
    /**
     * Handle given login request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle(Request $request);
}
