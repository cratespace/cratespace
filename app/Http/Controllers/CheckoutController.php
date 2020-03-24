<?php

namespace App\Http\Controllers;

use App\Models\Space;

class CheckoutController extends Controller
{
    /**
     * Show checkout page.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if (! cache()->has('space')) {
            return redirect()->route('listings');
        }

        $space = cache('space');

        return view('checkout', [
            'space' => $space,
            'purchase' => app('purchase')->make($space)
        ]);
    }

    /**
     * Calculate prices and redirect to checkout page.
     *
     * @param  \App\Models\Space $space
     * @return  \Illuminate\Http\Response
     */
    public function store(Space $space)
    {
        cache()->put('space', $space);

        return redirect()->route('checkout');
    }

    /**
     * Cancel purchase and redirect to listings.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
    {
        cache()->flush();

        return redirect()->route('listings');
    }
}