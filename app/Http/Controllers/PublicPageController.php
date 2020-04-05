<?php

namespace App\Http\Controllers;

class PublicPageController extends Controller
{
    /**
     * Show requested public page.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(?string $page = null)
    {
        if (!is_null($page)) {
            return view($page);
        }

        return redirect('/');
    }
}
