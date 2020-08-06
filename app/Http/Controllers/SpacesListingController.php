<?php

namespace App\Http\Controllers;

use App\Filters\SpaceFilter;
use Illuminate\Http\Request;
use App\Models\Queries\SpaceQuery;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SpacesListingController extends Controller
{
    /**
     * Show listings page with all available and filtered spaces.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, SpaceFilter $filters)
    {
        cache()->flush();

        return view('public.landing.welcome', [
            'spaces' => $this->getSpaces($request, $filters),
            'options' => $this->getPlaces(),
        ]);
    }

    /**
     * Get spaces listings.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Filters\SpaceFilter $filters
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function getSpaces(Request $request, SpaceFilter $filters): LengthAwarePaginator
    {
        return SpaceQuery::list($filters)->paginate($request->perPage ?: 12);
    }

    /**
     * Get names of origin, destination locations of spaces.
     *
     * @return array
     */
    protected function getPlaces(): array
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
