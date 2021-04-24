<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class CsrfCookieController extends Controller
{
    /**
     * Return an empty response simply to trigger the storage of the CSRF cookie in the browser.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(): Response
    {
        return new Response('', 204);
    }
}
