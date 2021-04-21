<?php

namespace App\Http\Controllers\Concerns;

trait ReturnsResponse
{
    /**
     * Return a new response from the application.
     *
     * @param mixed  $content
     * @param string $uri
     * @param int    $status
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    protected function response($content, string $uri, int $status = 200)
    {
    }
}
