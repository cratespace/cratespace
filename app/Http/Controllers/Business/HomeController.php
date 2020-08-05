<?php

namespace App\Http\Controllers\Business;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Space;
use App\Reports\Generator;
use App\Reports\WeeklyReport;
use Illuminate\Support\Collection;
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
        return view('business.dashboard.home', [
            'spacesDeparting' => Space::departing()->get(),
            'pendingOrders' => Order::pending()->get(),
            'chart' => $this->generateReport(),
        ]);
    }

    /**
     * Generate orders report.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function generateReport(): Collection
    {
        $generator = new Generator('orders', true);
        $generator->setOptions([
            'report' => WeeklyReport::class,
            'limit' => null,
        ]);

        return $generator->generate()
            ->keyBy(function ($count, $date) {
                return Carbon::parse($date)->format('M j');
            });
    }
}
