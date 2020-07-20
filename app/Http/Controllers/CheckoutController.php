<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Support\Formatter;

class CheckoutController extends Controller
{
    /**
     * Show checkout page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Space $space)
    {
        return view('public.checkout.page', [
            'space' => $space,
            'charges' => $this->calculateChrages($space),
        ]);
    }

    /**
     * Calculate charges of customer purchase.
     *
     * @param \App\Models\Space $space
     *
     * @return array
     */
    protected function calculateChrages(Space $space): array
    {
        $service = ($space->getPriceInCents() + $space->getTaxInCents()) / config('charges.service');

        return [
            'price' => Formatter::moneyFormat($space->getPriceInCents()),
            'tax' => Formatter::moneyFormat($space->getTaxInCents()),
            'service' => Formatter::moneyFormat($service),
            'total' => Formatter::moneyFormat(
                $space->getPriceInCents() + $space->getTaxInCents() + $service
            ),
        ];
    }
}
