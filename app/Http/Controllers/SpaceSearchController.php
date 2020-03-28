<?php

namespace App\Http\Controllers;

use App\Models\Space;
use Illuminate\Http\Request;

class SpaceSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
}
