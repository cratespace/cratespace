<?php

namespace App\Http\Controllers\Business;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Space;
use App\Reports\Generator;
use App\Reports\WeeklyReport;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $generator = new Generator('orders', true);

        return view('business.dashboard.home', [
            'spacesDeparting' => Space::departing()->get(),
            'pendingOrders' => Order::pending()->get(),
            'chart' => $generator->generate(WeeklyReport::class)
                ->keyBy(function ($count, $date) {
                    return Carbon::parse($date)->format('M j');
                }),
        ]);
    }
}
