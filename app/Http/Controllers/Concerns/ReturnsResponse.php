<?php

namespace App\Http\Controllers\Concerns;

trait ReturnsResponse
{
    /**
     * Redirect to given path with success message.
     *
     * @param  string $path
     * @param  string $message
     * @return \Illuminate\Routing\RedirectResponse
     */
    protected function success($path, $message = 'Details succssfully saved.')
    {
        return redirect($path)->with(['status' => $message]);
    }
}
