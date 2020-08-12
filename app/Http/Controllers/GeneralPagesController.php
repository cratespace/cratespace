<?php

namespace App\Http\Controllers;

class GeneralPagesController extends Controller
{
    /**
     * Show privacy page.
     *
     * @return \Illuminate\View\View
     */
    public function privacy()
    {
        return view('public.general.privacy');
    }

    /**
     * Show privacy page.
     *
     * @return \Illuminate\View\View
     */
    public function terms()
    {
        return view('public.general.terms');
    }
}
