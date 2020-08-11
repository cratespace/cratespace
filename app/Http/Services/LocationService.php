<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Stevebauman\Location\Location as LocationIdentifier;

class LocationService extends Service
{
    /**
     * Instance of HTTP request.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Instance of IP retrieval service.
     *
     * @var \App\Http\Services\IpService
     */
    protected $ipService;

    /**
     * Create new instance of ip location retrieval service.
     *
     * @param \Illuminate\Http\Request          $request
     * @param \App\Http\Services\IpService|null $ipService
     */
    public function __construct(Request $request, ?Service $ipService = null)
    {
        $this->request = $request;
        $this->ipService = $ipService ?? new IpService($request);
    }

    /**
     * Get client location country or default to Sri Lanka.
     *
     * @return string
     */
    public function getCountry(): string
    {
        return $this->get()->countryName;
    }

    /**
     * Get client location country code or default to Sri Lankan country code.
     *
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->get()->countryCode;
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        return (new LocationIdentifier())->get(
            $this->getValidIp() ?? $this->request->ip
        );
    }

    /**
     * Retrieve request user agent IP.
     *
     * @return string|null
     */
    public function getValidIp()
    {
        return $this->getIpService()->get();
    }

    /**
     * Get IP address retriever.
     *
     * @return \App\Http\Services\IpService
     */
    protected function getIpService(): IpService
    {
        return $this->ipService;
    }
}
