<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Space;
use App\Reports\WeeklyReport;
use App\Http\Controllers\Concerns\CountsItems;

class HomeController extends Controller
{
    use CountsItems;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke()
    {
        $graph = new WeeklyReport(new Order);
        $graphData = $graph->make(user('id'));

        if (is_null(user('business')->email)) {
            return redirect()->route('users.edit', [
                'user' => user(), 'page' => 'business',
            ]);
        }

        return view('businesses.home', [
            'chart' => $graphData,
            'spaces' => $this->getCountOf(Space::class, Space::whereUserId(user('id'))->get()),
            'orders' => $this->getCountOf(Order::class, Order::whereUserId(user('id'))->get()),
        ]);
    }
}
