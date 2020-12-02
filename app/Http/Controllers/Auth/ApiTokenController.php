<?php

namespace App\Http\Controllers\Auth;

use App\Auth\Api\Permission;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\CreateNewApiTokenRequest;

class ApiTokenController extends Controller
{
    /**
     * Show the user API token screen.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request): View
    {
        return view('auth.profile.api', [
            'tokens' => $request->user()->tokens,
            'availablePermissions' => Permission::$permissions,
            'defaultPermissions' => Permission::$defaultPermissions,
        ]);
    }

    /**
     * Create a new API token.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(CreateNewApiTokenRequest $request): Response
    {
        $token = $request->user()->createToken(
            $request->name, Permission::validPermissions($request->input('permissions', []))
        );

        $token = explode('|', $token->plainTextToken, 2)[1];

        $request->wantsJson()
            ? response()->json($token, 200)
            : back()->with('flash', copmact('token'));
    }

    /**
     * Update the given API token's permissions.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $tokenId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, $tokenId): Response
    {
        $token = $request->user()->tokens()->where('id', $tokenId)->firstOrFail();

        $token->forceFill([
            'abilities' => Permission::validPermissions($request->input('permissions', [])),
        ])->save();

        $request->wantsJson()
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

        $request->wantsJson()
            ? response()->json('', 204)
            : back();
    }
}
