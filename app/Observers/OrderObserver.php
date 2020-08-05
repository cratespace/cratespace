<?php

namespace App\Observers;

use App\Models\Order;
use App\Support\UidGenerator;
use App\Exceptions\ChargesNotFountException;

class OrderObserver
{
    /**
     * Instance of order currently being observed.
     *
     * @var \App\Models\Order
     */
    protected $order;

    /**
     * Handle the order "creating" event.
     *
     * @param \App\Models\Order $order
     *
     * @return void
     */
    public function creating(Order $order)
    {
        $this->order = $order;

        $this->setBusinessRelation()
            ->calculateCharges()
            ->generateConfirmationNumber();
    }

    /**
     * Set the ID of the business the order belongs to.
     *
     * @return \App\Observers\OrderObserver
     */
    protected function setBusinessRelation(): OrderObserver
    {
        if (!$this->attributeIsNull($this->order->user_id)) {
            return $this;
        }

        $this->order->user_id = $this->order->space->user_id;

        return $this;
    }

    /**
     * Generate a unique confirmation number.
     *
     * @return \App\Observers\OrderObserver
     */
    protected function generateConfirmationNumber(): OrderObserver
    {
        if (!$this->attributeIsNull($this->order->confirmation_number)) {
            return $this;
        }

        $generator = new UidGenerator();

        $generator->setOptions([
            'type' => 'orderConfirmationNumber',
            'parameters' => null,
        ]);

        $this->order->confirmation_number = $generator->generate();

        return $this;
    }

    /**
     * Calculate charges to be set.
     *
     * @return \App\Observers\OrderObserver
     */
    protected function calculateCharges(): OrderObserver
    {
        if (!$this->attributeIsNull($this->order->total)) {
            return $this;
        }

        foreach (static::getChrages() as $name => $amount) {
            $this->order->{$name} = $amount;
        }

        return $this;
    }

    /**
     * Get all pre-calculated charges.
     *
     * @return array
     */
    protected static function getChrages(): array
    {
        if (cache()->has('charges')) {
            return cache()->get('charges');
        }

        throw new ChargesNotFountException('Charges have not been calculated');
    }

    /**
     * Determine if given attribute is null.
     *
     * @param \object|array|string|int $attribute
     *
     * @return bool
     */
    protected function attributeIsNull($attribute): bool
    {
        return $attribute === null;
    }
}
