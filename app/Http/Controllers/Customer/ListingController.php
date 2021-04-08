<?php

namespace App\Http\Controllers\Customer;

use Inertia\Inertia;
use App\Queries\SpaceQuery;
use App\Filters\SpaceFilter;
use App\Http\Controllers\Controller;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Queries\SpaceQuery  $query
     * @param \App\Filters\SpaceFilter $filters
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(SpaceQuery $query, SpaceFilter $filters)
    {
        return Inertia::render('Welcome/Index', [
            'products' => $query->listing($filters)->paginate(),
        ]);
    }
}
