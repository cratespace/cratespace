<?php

namespace App\Http\Controllers\Customer;

use Inertia\Inertia;
use App\Models\Space;
use App\Filters\SpaceFilter;
use App\Http\Controllers\Controller;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Filters\SpaceFilter $filters
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(SpaceFilter $filters)
    {
        return Inertia::render('Welcome/Index', [
            'products' => Space::listing($filters)->paginate(),
        ]);
    }
}
