<?php

namespace App\Http\Controllers\Business;

use Inertia\Inertia;
use App\Models\Space;
use App\Filters\SpaceFilter;
use App\Http\Controllers\Controller;
use App\Actions\Business\CreateNewSpace;
use Inertia\Response as InertiaResponse;
use App\Http\Requests\Business\SpaceRequest;
use App\Http\Responses\Business\SpaceResponse;

class SpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Filters\SpaceFilter $filter
     *
     * @return \Inertia\Response
     */
    public function index(SpaceFilter $filter): InertiaResponse
    {
        $this->authorize('viewAny', new Space());

        return Inertia::render('Business/Spaces/Index', [
            'spaces' => [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(): InertiaResponse
    {
        $this->authorize('viewAny', new Space());

        return Inertia::render('Business/Spaces/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Business\SpaceRequest $request
     * @param \App\Actions\Business\CreateNewSpace     $request
     *
     * @return mixed
     */
    public function store(SpaceRequest $request, CreateNewSpace $creator)
    {
        $space = $creator->create($request->validated());

        return SpaceResponse::dispatch($space);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Space $space
     *
     * @return \Inertia\Response
     */
    public function show(Space $space): InertiaResponse
    {
        $this->authorize('manage', $space);

        return Inertia::render('Business/Spaces/Show', compact('space'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Space $space
     *
     * @return \Inertia\Response
     */
    public function edit(Space $space): InertiaResponse
    {
        $this->authorize('manage', $space);

        return Inertia::render('Business/Spaces/Edit', compact('space'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Business\SpaceRequest $request
     * @param \App\Models\Space                        $space
     *
     * @return mixed
     */
    public function update(SpaceRequest $request, Space $space)
    {
        $space->update($request->validated());

        return SpaceResponse::dispatch($space->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Space $space
     *
     * @return mixed
     */
    public function destroy(Space $space)
    {
        $space->delete();

        return SpaceResponse::dispatch();
    }
}
