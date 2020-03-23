<?php

namespace App\Http\Services;

use Stevebauman\Location\Facades\Location;

class IpIdentifier
{
    /**
     * IP addresses that are not allowed to be considered.
     *
     * @var array
     */
    protected $blacklist = [
        '10.0.0.0|10.255.255.255',
        '172.16.0.0|172.31.255.255',
        '192.168.0.0|192.168.255.255',
        '169.254.0.0|169.254.255.255',
        '127.0.0.0|127.255.255.255'
    ];

    /**
     * Index of sources to get client IP address from.
     *
     * @var array
     */
    protected $sources = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR'
    ];

    /**
     * Currently identified IP address.
     *
     * @var sttring
     */
    protected $adddress;

    /**
     * Get client IP address from valid source.
     *
     * @return string
     */
    public function get()
    {
        foreach ($this->sources as $source) {
            $this->address = $_SERVER[$source] ?? request()->ip();
        }

        if ($this->isPrivate($this->address)) {
            return null;
        }

        return $this->address;
    }

    /**
     * Identify postion of client from client IP address.
     *
     * @return string
     */
    public function position()
    {
        return Location::get($this->get() ?? null);
    }

    /**
     * Determine if the identified IP address is black listed.
     *
     * @param string $address
     * @return bool
     */
    protected function isPrivate($address)
    {
        $longIp = ip2long($address);

        if ($longIp === -1) {
            return false;
        }

        foreach ($this->getBlackList() as $address) {
            [$start, $end] = explode('|', $address);

            if ($this->compareAddresses($start, $end, $longIp)) {
                return true;
            }
        }
    }

    /**
     * Compare ip address to blacklisted ranges.
     *
     * @param  string $start
     * @param  string $end
     * @param  string $address
     * @return bool
     */
    protected function compareAddresses($start, $end, $address)
    {
        return $address >= ip2long($start) && $address <= ip2long($end);
    }

    /**
     * Get all blacklisted IPs.
     *
     * @return array
     */
    protected function getBlackList()
    {
        return array_merge($this->blacklist, config('location.blacklist'));
    }
}
