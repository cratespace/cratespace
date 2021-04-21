<?php

namespace App\Auth\Guards;

use App\Auth\Config\Auth;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard as AuthGuard;

class ApiGuard implements AuthGuard
{
    use GuardHelpers;

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user(): ?Authenticatable
    {
        return $this->auth->guard(Auth::guard('web'))->user();
    }

    /**
     * Validate a user's credentials.
     *
     * @param array $credentials
     *
     * @return bool
     */
    public function validate(array $credentials = []): bool
    {
        return $this->expiration &&
            $credentials['accessToken']->created_at->lte(
                now()->subMinutes($this->expiration)
            );
    }
}
