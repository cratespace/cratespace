<?php

namespace App\Http\Controllers\Business;

use App\Models\Order;
use App\Reports\WeeklyReport;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
        $query = DB::table('spaces')
            ->where('user_id', user('id'));

        $graph = new WeeklyReport($query);

        return view('business.dashboard.home', [
            'chart' => $graph->make(),
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
