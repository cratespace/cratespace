<?php

namespace App\Http\Requests\Traits;

trait CheckAuthorization
{
    /**
     * Determine if user making request is authenticated.
     *
     * @return bool
     */
    protected function authenticated()
    {
        return auth()->check() && $this->user()->is(user());
    }

    /**
     * Determine if requested resource belongs to the user making the request.
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     *
     * @return bool
     */
    protected function resourceBelongsToUser($resource)
    {
        return $this->authenticated() && $this->user()->is($resource->user);
    }
}
