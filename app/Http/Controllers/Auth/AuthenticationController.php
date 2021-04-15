<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Providers\AuthServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use Inertia\Response as InertiaResponse;
use App\Http\Responses\Auth\LoginResponse;

class AuthenticationController extends Controller
{
    /**
     * Show the login view.
     *
     * @return \Inertia\Response
     */
    public function create(): InertiaResponse
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Attempt to authenticate a new session.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     *
     * @return mixed
     */
    public function store(LoginRequest $request)
    {
        return $this->pipeline()
            ->send($request)
            ->through(static::loginPipeline())
            ->then(fn () => LoginResponse::dispatch());
    }

    /**
     * Get array of authentication middlware.
     *
     * @return array
     */
    public static function loginPipeline(): array
    {
        return array_filter(AuthServiceProvider::loginPipeline());
    }
}
