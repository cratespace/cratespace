<?php

namespace App\Billing\Charges;

class Charge
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = (array) $data;
    }

    public function amount()
    {
        return $this->data['amount'];
    }

    public function cardLastFour()
    {
        return $this->data['card_last_four'];
    }

    public function destination()
    {
        return $this->data['destination'];
    }

    public function getData(): array
    {
        return $this->data;
    }
}
