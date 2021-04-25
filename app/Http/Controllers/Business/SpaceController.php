<?php

namespace App\Http\Controllers\Business;

use App\Models\Space;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Products\CreateNewSpace;
use App\Http\Requests\Business\SpaceRequest;
use App\Http\Responses\Business\SpaceResponse;

class SpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Business\SpaceRequest $request
     * @param \App\Actions\Products\CreateNewSpace     $creator
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
     * @return \Illuminate\Http\Response
     */
    public function show(Space $space)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Space $space
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Space $space)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Space        $space
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Space $space)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Space $space
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Space $space)
    {
    }
}
