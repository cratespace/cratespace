<?php

namespace App\Http\Contracts;

interface Services
{
    /**
     * Handle service request.
     *
     * @param int|string|array|null $request
     * @return string|bool
     */
    public function handle($request = null);
}
