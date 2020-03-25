<?php

namespace App\Listings;

use App\Models\User;
use App\Filters\Filter;
use App\Http\Services\Ip\Retriever;

class SpaceListing extends Listing
{
    /**
     * Fetch all relevant resources as collection.
     *
     * @param \App\Filters\Filters|null $filters
     * @param \App\Models\User|null $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get(Filter $filters, ?User $user = null)
    {
        return $this->getAuthorizedSpace($user)
            ->latest()
            ->filter($filters)
            ->paginate(request('perpage') ?? 10);
    }

    /**
     * Get allowable resource according to limitations.
     *
     * @param  \App\Models\User|null $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getAuthorizedSpace(?User $user = null)
    {
        if (! is_null($user)) {
            return $this->model->whereUserId($user->id);
        }

        $this->listings = $this->model->whereBase($this->getCountry());

        return $this->listings;
    }

    /**
     * Get client location country or default to Sri Lanka.
     *
     * @return string
     */
    protected function getCountry()
    {
        return $this->getIpRetriever()->position()->countryName;
    }

    /**
     * Get IP address retriever.
     *
     * @return \App\Http\Services\Ip\Retriever
     */
    protected function getIpRetriever()
    {
        return new Retriever();
    }
}
