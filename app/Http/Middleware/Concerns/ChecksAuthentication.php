<?php

namespace App\Http\Middleware\Concerns;

use Illuminate\Http\Request;

trait ChecksAuthentication
{
    /**
     * Check if the user making the request is authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function isAuthenticated(Request $request): bool
    {
        return ! is_null($request->user());
    }
}
