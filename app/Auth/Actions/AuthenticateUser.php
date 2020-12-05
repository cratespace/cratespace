<?php

namespace App\Auth\Actions;

use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\Providers\AuthServiceProvider;
use App\Contracts\Auth\AuthenticatesUsers;

class AuthenticateUser implements AuthenticatesUsers
{
    /**
     * Authenticate given login request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function authenticate(Request $request)
    {
        return $this->signInPipeline($request);
    }

    /**
     * Perform sign in attempt with request data.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    protected function signInPipeline(Request $request)
    {
        return (new Pipeline(app()))
            ->send($request)
            ->through(array_filter(AuthServiceProvider::$authenticationMiddleware));
    }

    /**
     * Default username attribute.
     *
     * @return string
     */
    protected function username(): string
    {
        return config('auth.defaults.username', 'email');
    }
}
