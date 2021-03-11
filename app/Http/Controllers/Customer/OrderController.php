<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use App\Models\Space;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Http\Responses\PurchaseResponse;
use App\Http\Responses\FailedPurchaseResponse;
use App\Contracts\Actions\Billing\MakesPurchase;

class OrderController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\PurchaseRequest           $request
     * @param \App\Contracts\Actions\Billing\MakesPurchase $purchaser
     * @param \App\Models\Space                            $space
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseRequest $request, MakesPurchase $purchaser, Space $space)
    {
        $order = $purchaser->purchase($request->validated(), $space);

        if ($order === false) {
            return FailedPurchaseResponse::dispatch();
        }

        return PurchaseResponse::dispatch($order);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->cancel();

        return response('', 204);
    }
}
