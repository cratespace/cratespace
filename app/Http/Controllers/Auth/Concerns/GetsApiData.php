<?php

namespace App\Http\Controllers\Auth\Concerns;

use App\Auth\Api\Permission;
use Illuminate\Contracts\Auth\Authenticatable;

trait GetsApiData
{
    /**
     * Get all tokens associated with the authenticated user.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return array
     */
    protected function getApiData(Authenticatable $user): array
    {
        return [
            'tokens' => $user->tokens,
            'availablePermissions' => Permission::$permissions,
            'defaultPermissions' => Permission::$defaultPermissions,
        ];
    }
}
