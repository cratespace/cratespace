<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show application dashboard.
     *
     * @return mixed
     */
    public function __invoke()
    {
        return view('business.dashboard');
    }
}
