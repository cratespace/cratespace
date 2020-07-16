<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Filters\SpaceFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpacesListingController extends Controller
{
    /**
     * Show listings page with all available and filtered spaces.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, SpaceFilter $filters)
    {
        return view('public.landing.welcome', [
            'spaces' => $this->getSpaces($request, $filters),
            'options' => $this->getPlaces(),
        ]);
    }

    protected function getSpaces(Request $request, SpaceFilter $filters)
    {
        return Space::list()
            ->filter($filters)
            ->paginate($request->perPage ?: 12);
    }

    protected function getPlaces()
    {
        $places = DB::table('spaces')
            ->select('origin', 'destination')
            ->distinct()
            ->get();

        $origins = $places->map(function ($place) {
            return $place->origin;
        })->sort();

        $destinations = $places->map(function ($place) {
            return $place->destination;
        })->sort();

        return compact('origins', 'destinations');
    }
}