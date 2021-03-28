<?php

namespace App\Http\Controllers\Business;

use App\Models\Payout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayoutController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Payout $payout
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payout $payout)
    {
    }
}
