<?php

namespace App\Contracts\Auth;

use Illuminate\Http\Request;

interface CreatesApiTokens
{
    /**
     * Create new personal access token for authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function create(Request $request);
}
