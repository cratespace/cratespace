<?php

namespace App\Http\Controllers\Business;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Invitable;
use App\Actions\Business\UpdateBusinessProfile;
use App\Http\Requests\Business\BusinessRequest;
use App\Http\Responses\Business\BusinessResponse;
use Cratespace\Sentinel\Contracts\Actions\CreatesNewUsers;
use Cratespace\Sentinel\Http\Responses\UpdateUserProfileResponse;

class BusinessController extends Controller
{
    use Invitable;

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
        return Inertia::render('Business/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Business\BusinessRequest            $request
     * @param \Cratespace\Sentinel\Contracts\Actions\CreatesNewUsers $request
     *
     * @return mixed
     */
    public function store(BusinessRequest $request, CreatesNewUsers $creator)
    {
        $user = $creator->create($request->validated());

        if ((bool) $request->invite) {
            $request->user()->setResponsibility($user);

            $this->invite($request, $user);
        }

        return BusinessResponse::dispatch($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Business\BusinessRequest $request
     * @param \App\Actions\Business\UpdateBusinessProfile $updater
     *
     * @return mixed
     */
    public function update(BusinessRequest $request, UpdateBusinessProfile $updater)
    {
        $updater->update($request->user(), $request->validated());

        return UpdateUserProfileResponse::dispatch();
    }
}
