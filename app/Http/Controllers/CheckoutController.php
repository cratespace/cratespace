<?php

namespace App\Http\Controllers;

use App\Models\Space;

class CheckoutController extends Controller
{
    /**
     * Show checkout page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Space $space)
    {
        return view('public.checkout.page', compact('space'));
    }
}
