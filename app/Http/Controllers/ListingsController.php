<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Filters\SpaceFilter;
use App\Http\Controllers\Concerns\FiltersFormData;

class ListingsController extends Controller
{
    /**
     * All available space listings.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $listings;

    /**
     * Create a new space controller instance.
     */
    public function __construct()
    {
        $this->listings = app('listings.space');
    }

    /**
     * Show listings page with all available and filtered spaces.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(SpaceFilter $filters)
    {
        $spaces = $this->listings->get($filters);

        return view('listings', [
            'spaces' => $spaces,
            'filters' => $this->filters($spaces)
        ]);
    }

    /**
     * Attributes to filter by.
     *
     * @return array
     */
    public function filters($spaces)
    {
        $filters = [];

        foreach ([
            'origins' => 'origin',
            'destinations' => 'destination'
        ] as $key => $attribute) {
            $filters[$key] = collect(array_unique(
                $spaces->pluck($attribute)->toArray()
            ))->sort();
        }

        return $filters;
    }
}
