<?php

namespace App\Auth\Traits;

use Closure;

trait HasBeforeSignInAction
{
    /**
     * Action to perform before attempting to sign in user.
     *
     * @var \Closure
     */
    protected $beforeSignIn;

    /**
     * Set action to be performed before attempting to sign in user.
     *
     * @param \Closure $callback
     *
     * @return void
     */
    public function setBeforeSignIn(Closure $callback): void
    {
        $this->beforeSignIn = $callback;
    }

    /**
     * Run before sign in callback.
     *
     * @param array $parameters
     *
     * @return mixed
     */
    public function runBeforeSignIn(array $parameters = [])
    {
        if (!is_null($this->beforeSignIn)) {
            return call_user_func_array($this->beforeSignIn, $parameters);
        }
    }
}
