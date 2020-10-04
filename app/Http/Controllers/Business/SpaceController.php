<?php

namespace App\Http\Controllers\Business;

use App\Models\Space;
use App\Queries\SpaceQuery;
use App\Filters\SpaceFilter;
use Illuminate\Http\Request;
use App\Http\Requests\SpaceRequest;
use App\Http\Controllers\Controller;

class SpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\SpaceRequest
     * @param \App\Filters\SpaceFilter
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SpaceFilter $filters)
    {
        $resource = SpaceQuery::ofBusiness(
            $filters,
            $request->search
        )->paginate($request->perPage ?? 10);

        return $request->wantsJson()
            ? $this->successJson($resource, 200)
            : view('business.spaces.index', compact('resource'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Space $space
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Space $space)
    {
        $this->authorize('manage', $space);

        return $request->wantsJson()
            ? $this->successJson($space->load(['order'])->toArray(), 200)
            : view('business.spaces.show', [
                'space' => $space,
                'order' => $space->order ?: null,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Space $space)
    {
        return view('business.spaces.create', compact('space'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\SpaceRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SpaceRequest $request)
    {
        $space = user()->spaces()->create($request->validated());

        return $request->wantsJson()
            ? $this->successJson($space, 201)
            : $this->success($space->path);
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
        $this->authorize('manage', $space);

        return view('business.spaces.edit', compact('space'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\SpaceRequest $request
     * @param \App\Models\Space               $space
     *
     * @return \Illuminate\Http\Response
     */
    public function update(SpaceRequest $request, Space $space)
    {
        $space->update($request->validatedWithoutNulls());

        return $request->wantsJson()
            ? $this->successJson($space->fresh(), 201)
            : $this->success($space->fresh()->path);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Space $space
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Space $space)
    {
        $this->authorize('delete', $space);

        $space->delete();

        return $request->wantsJson()
            ? $this->successJson([], 204)
            : $this->success(route('spaces.index'));
    }
}
