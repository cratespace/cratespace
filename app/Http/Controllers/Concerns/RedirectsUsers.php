<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\RedirectResponse;

trait RedirectsUsers
{
    /**
     * Get the redirect response for the given action.
     *
     * @param mixed $action
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectPath($action): RedirectResponse
    {
        if (method_exists($action, 'redirectTo')) {
            $response = $action->redirectTo();
        } else {
            $response = property_exists($action, 'redirectTo')
                ? $action->redirectTo
                : config('auth.defaults.home');
        }

        return $response instanceof RedirectResponse
            ? $response
            : redirect($response);
    }
}
