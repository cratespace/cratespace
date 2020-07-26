<?php

namespace App\Http\Services\Ip;

class Validator
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
        '127.0.0.0|127.255.255.255',
    ];

    /**
     * Determine if the identified IP address is black listed.
     *
     * @param string $address
     *
     * @return bool
     */
    public function isPrivate(string $address): bool
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
     * @param string $start
     * @param string $end
     * @param string $address
     *
     * @return bool
     */
    protected function compareAddresses(string $start, string $end, string $address): bool
    {
        return $address >= ip2long($start) && $address <= ip2long($end);
    }

    /**
     * Get all blacklisted IPs.
     *
     * @return array
     */
    protected function getBlackList(): array
    {
        return array_merge($this->blacklist, config('location.blacklist'));
    }
}
