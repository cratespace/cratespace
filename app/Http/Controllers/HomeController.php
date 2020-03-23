<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke()
    {
        if (is_null(user('business')->email)) {
            return redirect()->route('users.edit', [
                'user' => user(), 'page' => 'business'
            ]);
        }

        return view('businesses.home');
    }
}
