<?php

namespace App\Http\Controllers\Customer;

use Inertia\Inertia;
use App\Queries\SpaceQuery;
use App\Filters\SpaceFilter;
use App\Http\Controllers\Controller;
use Inertia\Response as InertiaResponse;

class SpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Filters\SpaceFilter $filters
     * @param \App\Queries\SpaceQuery  $query
     *
     * @return \Inertia\Response
     */
    public function __invoke(SpaceFilter $filters, SpaceQuery $query): InertiaResponse
    {
        return Inertia::render('Welcome/Index', [
            'spaces' => $query->listing($filters)->paginate(),
            'origins' => $query->origins(),
            'destinations' => $query->destinations(),
        ]);
    }
}
