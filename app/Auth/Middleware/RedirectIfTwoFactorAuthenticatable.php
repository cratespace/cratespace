<?php

namespace App\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Contracts\Auth\HandleAuthentication;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\Traits\TwoFactorAuthenticatable;
use App\Events\TwoFactorAuthenticationChallenged;
use App\Http\Responses\Auth\TwoFactorChallengeResponse;

class RedirectIfTwoFactorAuthenticatable extends Authenticate implements HandleAuthentication
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $this->validateCredentials($request);

        if ($this->twoFactorAuthenticationEnabled($user)) {
            $request->session()->put([
                'login.id' => $user->getKey(),
                'login.remember' => $request->filled('remember'),
            ]);

            TwoFactorAuthenticationChallenged::dispatch($user);

            return app(TwoFactorChallengeResponse::class);
        }

        return $next($request);
    }

    /**
     * Determine if two factor authentication is enabled on the given user model instance.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $user
     *
     * @return bool
     */
    protected function twoFactorAuthenticationEnabled(?Authenticatable $user = null): bool
    {
        return optional($user)->two_factor_secret && in_array(
            TwoFactorAuthenticatable::class,
            class_uses_recursive($user)
        );
    }
}
