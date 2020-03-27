<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Filters\SpaceFilter;

class ListingsController extends Controller
{
    /**
     * Show listings page with all available and filtered spaces.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(SpaceFilter $filters)
    {
        $spaces = $this->getSpaces($filters);

        return view('listings', [
            'spaces' => $spaces,
            'filters' => $this->filters($spaces)
        ]);
    }

    /**
     * Get specified spaces.
     *
     * @param  \App\Filters\SpaceFilter $filter
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getSpaces(SpaceFilter $filters)
    {
        return Space::list()
            ->with('user')
            ->filter($filters)
            ->latest()
            ->paginate(10);
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
