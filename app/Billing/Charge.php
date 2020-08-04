<?php

namespace App\Billing;

use Illuminate\Support\Str;

class Charge
{
    /**
     * Card data.
     *
     * @var array
     */
    protected $data;

    /**
     * Charge ID,.
     *
     * @var string
     */
    public $id;

    /**
     * Create new cratespace charge instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->id = Str::random(40);
    }

    /**
     * Amouont to be charged.
     *
     * @return int
     */
    public function amount(): int
    {
        return $this->data['amount'];
    }

    /**
     * Last four digits of number on card provided.
     *
     * @return int
     */
    public function cardLastFour(): int
    {
        return $this->data['card_last_four'];
    }

    /**
     * Destination account of charge to be made.
     *
     * @return string
     */
    public function destination(): string
    {
        return $this->data['destination'];
    }
}
