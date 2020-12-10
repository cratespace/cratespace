<?php

namespace App\Http\Controllers\Auth;

use App\Auth\Api\Permission;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Contracts\Auth\CreatesApiTokens;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\CreateNewApiTokenRequest;

class ApiTokenController extends Controller
{
    /**
     * Show the user API token screen.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response|Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $apiData = [
            'tokens' => $request->user()->tokens,
            'availablePermissions' => Permission::$permissions,
            'defaultPermissions' => Permission::$defaultPermissions,
        ];

        if ($request->wantsJson()) {
            return response()->json($apiData);
        }

        return view('api.index', $apiData);
    }

    /**
     * Create a new API token.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(CreateNewApiTokenRequest $request, CreatesApiTokens $creator): Response
    {
        $token = explode('|', $creator->create($request)->plainTextToken, 2)[1];

        return $request->wantsJson()
            ? response()->json(compact('token'))
            : back()->with('flash', compact('token'));
    }

    /**
     * Update the given API token's permissions.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $tokenId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, string $tokenId): Response
    {
        $token = $request->user()->tokens()->where('id', $tokenId)->firstOrFail();

        $token->forceFill([
            'abilities' => Permission::validPermissions($request->input('permissions', [])),
        ])->save();

        return $request->wantsJson()
            ? response()->json('', 200)
            : back();
    }

    /**
     * Delete the given API token.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $tokenId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Request $request, string $tokenId): Response
    {
        $request->user()->tokens()->where('id', $tokenId)->delete();

        return $request->wantsJson()
            ? response()->json('', 204)
            : back();
    }
}
