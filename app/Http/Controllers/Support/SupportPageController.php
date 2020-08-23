<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;

class SupportPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return view('support.index');
    }
}
