<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Contracts\Billing\CalculatesCharges;

class CheckoutController extends Controller
{
    /**
     * Show checkout page.
     *
     * @param \App\Contracts\Billing\CalculatesCharges
     * @param \pp\Models\Space
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke(CalculatesCharges $calculator, Space $space)
    {
        return view('public.checkout.page', [
            'space' => $space,
            'charges' => $calculator->calculate($space),
        ]);
    }
}
