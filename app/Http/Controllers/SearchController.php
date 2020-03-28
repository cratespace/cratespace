<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Space;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function spaces()
    {
        $spaces = Space::search(request('q'))
            ->where('user_id', user('id'))
            ->paginate(10);

        if (request()->expectsJson()) {
            return $spaces;
        }

        return view('businesses.spaces.index', [
            'spaces' =>  $spaces,
            'counts' => $this->getSpacesCount()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orders()
    {
        $orders = Order::search(request('q'))
            ->where('user_id', user('id'))
            ->paginate(10);

        if (request()->expectsJson()) {
            return $orders;
        }

        return view('businesses.orders.index', [
            'orders' => $orders,
            'counts' => $this->getOrdersCount()
        ]);
    }

    protected function getSpacesCount()
    {
        $counts = [];

        foreach ([
            'available' => 'Available',
            'ordered' => 'Ordered',
            'completed' => 'Completed',
            'expired' => 'Expired'
        ] as $key => $status) {
            $counts[$key] = user()->spaces()->whereStatus($status)->count();
        }

        return $counts;
    }

    protected function getOrdersCount()
    {
        $counts = [];

        foreach ([
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'completed' => 'Completed',
            'canceled' => 'Canceled'
        ] as $key => $status) {
            $counts[$key] = user()->orders()->whereStatus($status)->count();
        }

        return $counts;
    }
}
