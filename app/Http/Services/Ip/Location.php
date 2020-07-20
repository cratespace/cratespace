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
    public function getCountry()
    {
        return $this->position()->countryName;
    }

    /**
     * Identify postion of client from client IP address.
     *
     * @return string
     */
    public function position()
    {
        return LocationIdentifier::get($this->getIpRetriever()->get());
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
