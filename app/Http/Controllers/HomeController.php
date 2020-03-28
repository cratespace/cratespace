<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Reports\YearlyReport;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke()
    {
        $graph = new YearlyReport(new Order);
        $graphData = $graph->make(user('id'));

        if (is_null(user('business')->email)) {
            return redirect()->route('users.edit', [
                'user' => user(), 'page' => 'business',
            ]);
        }

        return view('businesses.home', [
            'chart' => $graphData,
        ]);
    }
}
