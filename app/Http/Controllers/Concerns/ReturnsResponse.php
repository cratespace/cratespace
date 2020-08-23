<?php

namespace App\Http\Controllers\Concerns;

trait ReturnsResponse
{
    /**
     * Redirect to given path with success message.
     *
     * @param string $path
     * @param string $message
     *
     * @return \Illuminate\Routing\RedirectResponse
     */
    protected function success(string $path, string $message = 'Details successfully saved.')
    {
        return redirect($path)->with(['status' => $message]);
    }

    /**
     * Returns a JSON response with given data attached.
     *
     * @param array $data
     * @param int   $code
     *
     * @return \Illuminate\Routing\RedirectResponse
     */
    protected function successJson(array $data = [], int $code = 200)
    {
        return response($data, $code);
    }

    /**
     * Returns a JSON response with given data attached.
     *
     * @param array $data
     * @param int   $code
     *
     * @return \Illuminate\Routing\RedirectResponse
     */
    protected function unAuthorizedJson(array $data = [], int $code = 422)
    {
        return response($data, $code);
    }
}
