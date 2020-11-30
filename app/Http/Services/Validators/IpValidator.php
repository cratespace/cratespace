<?php

namespace App\Http\Services\Validators;

use App\Contracts\Support\Validator as ValidatorContract;

class IpValidator implements ValidatorContract
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
     * Determine if the given item passes the given standards.
     *
     * @param mixed      $item
     * @param array|null $options
     *
     * @return bool
     */
    public function validate($item, ?array $options = null): bool
    {
        $longIp = ip2long($item);

        if ($longIp === -1) {
            return false;
        }

        foreach ($this->getBlackList() as $address) {
            [$start, $end] = explode('|', $address);

            if ($this->compareAddress($start, $end, $longIp)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Compare IP address to blacklisted ranges.
     *
     * @param string $start
     * @param string $end
     * @param string $address
     *
     * @return bool
     */
    protected function compareAddress(string $start, string $end, string $address): bool
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
