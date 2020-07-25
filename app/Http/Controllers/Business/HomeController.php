<?php

namespace App\Http\Controllers\Business;

use App\Models\Order;
use App\Reports\WeeklyReport;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('business.dashboard.home', [
            'chart' => collect([
                '1' => 12,
                '2' => 6,
                '3' => 8,
                '4' => 10,
                '5' => 9,
                '6' => 2,
                '7' => 12,
            ]),
        ]);
    }

    protected function makeReportFor(): Collection
    {
        return (new WeeklyReport($this->getBusinessOrders()))->make();
    }

    protected function getBusinessOrders(): Builder
    {
        return Order::whereUserId(user('id'));
    }
}
