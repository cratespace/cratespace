<?php

namespace App\Auth\Actions;

use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\Providers\AuthServiceProvider;
use App\Contracts\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Foundation\Application;

class AuthenticateUser implements AuthenticatesUsers
{
    /**
     * Create new authenticator instance.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

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
        return (new Pipeline($this->app))
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
