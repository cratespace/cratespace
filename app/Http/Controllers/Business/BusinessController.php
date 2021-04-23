<?php

namespace App\Http\Controllers\Business;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Contracts\Actions\CreatesNewUsers;
use App\Http\Requests\Business\BusinessRequest;
use App\Http\Responses\Business\BusinessResponse;

class BusinessController extends Controller
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
        return Inertia::render('Business/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BusinessRequest $request, CreatesNewUsers $creator)
    {
        $user = $creator->create($request->validated());

        if ((bool) $request->invite) {
            $request->user()->setResponsibility($user);

            return redirect()->route('invitations.store', compact('user'));
        }

        return BusinessResponse::dispatch($user);
    }
}
