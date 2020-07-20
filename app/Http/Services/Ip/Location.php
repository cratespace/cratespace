<?php

namespace App\Http\Services\Ip;

use Stevebauman\Location\Facades\Location as LocationIdentifier;

class Location
{
    /**
     * Get client location country or default to Sri Lanka.
     *
     * @return string
     */
    public function getCountry(): string
    {
        return $this->position()->countryName;
    }

    /**
     * Identify postion of client from client IP address.
     *
     * @return string
     */
    public function position(): string
    {
        return LocationIdentifier::get($this->getIpRetriever()->get());
    }

    /**
     * Get IP address retriever.
     *
     * @return \App\Http\Services\Ip\Retriever
     */
    protected function getIpRetriever(): Retriever
    {
        return new Retriever();
    }
}
