<?php

namespace App\Http\Controllers\Business;

use App\Models\Payout;
use App\Http\Controllers\Controller;

class PayoutController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Payout $payout
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payout $payout)
    {
        $payout->cancel();
    }
}
