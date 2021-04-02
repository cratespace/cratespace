<?php

namespace App\Http\Controllers\Business;

use App\Models\Space;
use App\Http\Requests\SpaceRequest;
use App\Http\Controllers\Controller;
use App\Http\Responses\SpaceResponse;
use App\Contracts\Actions\CreatesNewResources;

class SpaceController extends Controller
{
    /**
     * Create new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('money')->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create()
    {
        $this->authorize('manage', new Space());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\SpaceRequest            $request
     * @param \App\Contracts\Actions\CreatesNewResources $creator
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(SpaceRequest $request, CreatesNewResources $creator)
    {
        $space = $creator->create(Space::class, $request->validated());

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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Space        $space
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

        return SpaceResponse::dispatch();
    }
}
