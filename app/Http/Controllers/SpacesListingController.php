<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Filters\SpaceFilter;

class SpacesListingController extends Controller
{
    /**
     * All listings available in the customer's country.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $listing;

    /**
     * Show listings page with all available and filtered spaces.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(SpaceFilter $filters)
    {
        // $spaces = $this->getSpaces($filters);

        return view('public.landing.welcome', [
            'spaces' => Space::latest()->paginate(request('perPage') ?: 10),
            // 'filters' => $this->getFilters(),
        ]);
    }

    /**
     * Get specified spaces.
     *
     * @param \App\Filters\SpaceFilter $filter
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getSpaces(SpaceFilter $filters)
    {
        $spaces = [];

        $this->listing = $spaces->get();

        return $spaces->with('user')
            ->filter($filters)
            ->latest()
            ->paginate(12);
    }

    /**
     * Attributes to filter by.
     *
     * @return array
     */
    public function getFilters()
    {
        $filters = [];

        foreach ([
            'origins' => 'origin',
            'destinations' => 'destination',
        ] as $key => $attribute) {
            $filters[$key] = collect(array_unique(
                $this->listing->pluck($attribute)->toArray()
            ))->sort();
        }

        return $filters;
    }
}
