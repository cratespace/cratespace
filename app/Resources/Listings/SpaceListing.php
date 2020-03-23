<?php

namespace App\Resources\Listings;

use App\Models\User;
use App\Filters\Filter;
use App\Http\Services\IpIdentifier;

class SpaceListing extends Listing
{
    /**
     * Fetch all relevant resources as collection.
     *
     * @param \App\Filters\Filters|null $filters
     * @param \App\Models\User|null $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get(Filter $filters, User $user = null)
    {
        return $this->getAuthorizedSpace($user)
            ->latest()
            ->filter($filters)
            ->paginate(request('perpage') ?? 12);
    }

    /**
     * Get allowable resource according to limitations.
     *
     * @param  \App\Models\User|null $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getAuthorizedSpace(User $user = null)
    {
        if (! is_null($user)) {
            return $this->model->whereUserId($user->id);
        }

        $this->listings = $this->applyRestrictions(
            $this->model->whereStatus('Available')
        );

        return $this->listings;
    }

    /**
     * Apply geo restrictions to resources.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyRestrictions($builder)
    {
        return $builder->whereBase($this->getCountry());
    }

    /**
     * Get client location country or default to Sri Lanka.
     *
     * @return string
     */
    protected function getCountry()
    {
        return (new IpIdentifier())->position()->countryName;
    }
}
