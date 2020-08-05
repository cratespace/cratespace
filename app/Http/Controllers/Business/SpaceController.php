<?php

namespace App\Http\Controllers\Business;

use App\Models\Space;
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
        $this->authorize('manage', new Space());

        return view('business.spaces.index', [
            'resource' => Space::ofBusiness($filters, $request->search)
                ->paginate($request->perPage ?? 10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('business.spaces.create', [
            'space' => new Space(),
        ]);
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
        $space = Space::create($reqeust->validated());

        if ($request->wantsJson()) {
            return response($space, 201);
        }

        return redirect()->to($space->path());
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
        $this->authorize('manage', $space);

        return view('business.spaces.show', compact('space'));
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
        $space->update($request->validated());

        if ($request->wantsJson()) {
            return response($space->fresh(), 201);
        }

        return redirect()->to($space->fresh()->path());
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
        $this->authorize('delete', $space);

        $space->delete();

        if ($request->wantsJson()) {
            return response([], 204);
        }

        return redirect()->route('spaces.index');
    }
}
