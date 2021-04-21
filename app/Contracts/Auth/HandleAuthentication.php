<?php

namespace App\Contracts\Auth;

use Closure;
use Illuminate\Http\Request;

interface HandleAuthentication
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next);
}
