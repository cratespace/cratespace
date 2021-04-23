<?php

namespace App\Http\Controllers\Business;

use Inertia\Inertia;
use App\Models\Space;
use App\Http\Controllers\Controller;
use App\Actions\Product\CreateNewSpace;
use App\Http\Requests\Business\SpaceRequest;
use App\Http\Responses\Business\SpaceResponse;

class SpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $this->authorize('manage', new Space());

        return Inertia::render('Business/Spaces/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create()
    {
        $this->authorize('manage', new Space());

        return Inertia::render('Business/Spaces/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Business\SpaceRequest $request
     * @param \App\Actions\Product\CreateNewSpace      $creator
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(SpaceRequest $request, CreateNewSpace $creator)
    {
        $space = $creator->create($request->validated(), Space::class);

        return SpaceResponse::dispatch($space);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Space $space
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Space $space)
    {
        $this->authorize('manage', $space);

        return Inertia::render('Business/Spaces/Show', compact('space'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Space $space
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Space $space)
    {
        $this->authorize('manage', $space);

        return Inertia::render('Business/Spaces/Edit', compact('space'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Request\Business\SpaceRequest $request
     * @param \App\Models\Space                       $space
     *
     * @return \Symfony\Component\HttpFoundation\Response
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Space $space)
    {
        $this->authorize('manage', $space);

        $space->delete();

        return SpaceResponse::dispatch();
    }
}
