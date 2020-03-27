<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Filters\SpaceFilter;
use App\Resources\Spaces\Listings;
use App\Resources\Listings\SpaceListing;
use App\Http\Requests\Space as SpaceForm;
use App\Http\Controllers\Concerns\ManagesListings;

class SpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\SpaceFilter $filters
     * @return \Illuminate\Http\Response
     */
    public function index(SpaceFilter $filters)
    {
        if (! request()->has('status')) {
            return redirect()->route('spaces.index', ['status' => 'Available']);
        }

        return view('businesses.spaces.index', [
            'spaces' => user()->spaces()->filter($filters)->latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('businesses.spaces.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Space  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpaceForm $request)
    {
        user()->spaces()->create($request->validated());

        return $this->success(route('spaces.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Space  $space
     * @return \Illuminate\Http\Response
     */
    public function show(Space $space)
    {
        $this->authorize('manage', $space);

        return view('businesses.spaces.show', compact('space'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Space  $space
     * @return \Illuminate\Http\Response
     */
    public function edit(Space $space)
    {
        $this->authorize('manage', $space);

        return view('businesses.spaces.edit', compact('space'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Space  $request
     * @param  \App\Models\Space  $space
     * @return \Illuminate\Http\Response
     */
    public function update(SpaceForm $request, Space $space)
    {
        $space->update($request->validated());

        return $this->success(route('spaces.edit', $space), 'updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Space  $space
     * @return \Illuminate\Http\Response
     */
    public function destroy(Space $space)
    {
        $this->authorize('manage', $space);

        $space->delete();

        return $this->success(route('spaces.index'), 'deleted');
    }
}
