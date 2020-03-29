<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Space;
use Illuminate\Http\Request;
use App\Http\Controllers\Concerns\CountsItems;

class SearchController extends Controller
{
    use CountsItems;

    /**
     * Display a listing of spaces search results.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function spaces(Request $request)
    {
        $spaces = Space::search($request->q)
            ->where('user_id', user('id'))
            ->paginate(10);

        if (request()->expectsJson()) {
            return $spaces;
        }

        return view('businesses.spaces.index', [
            'spaces' => $spaces,
            'counts' => $this->getCountOf(
                Space::class,
                Space::whereUserId(user('id'))->get()
            ),
        ]);
    }

    /**
     * Display a listing of orders search results.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function orders(Request $request)
    {
        $orders = Order::search($request->q)
            ->where('user_id', user('id'))
            ->paginate(10);

        if (request()->expectsJson()) {
            return $orders;
        }

        return view('businesses.orders.index', [
            'orders' => $orders,
            'counts' => $this->getCountOf(
                Order::class,
                Order::whereUserId(user('id'))->get()
            ),
        ]);
    }
}
