<?php

namespace App\Http\Controllers\Business;

use Carbon\Carbon;
use App\Reports\Generator;
use App\Queries\OrderQuery;
use App\Queries\SpaceQuery;
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
            'user' => $this->getAuthUserDetails(),
            'spacesDeparting' => SpaceQuery::departing()->get(),
            'pendingOrders' => OrderQuery::pending()->get(),
            'chart' => $this->generateReport(),
        ]);
    }

    /**
     * Get authenticated user details with business and account details.
     *
     * @return \App\Models\User
     */
    protected function getAuthUserDetails()
    {
        return user()->load([
            'business' => function ($query) {
                $query->select('id', 'user_id', 'name', 'email');
            },
            'account' => function ($query) {
                $query->select('id', 'user_id', 'credit');
            },
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
