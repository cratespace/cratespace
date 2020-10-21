<?php

namespace App\Actions;

use App\Models\Order;
use App\Models\Space;
use App\Support\UidGenerator;
use Illuminate\Support\Facades\DB;
use App\Contracts\Actions\CreatesNewOrders;
use App\Exceptions\ChargesNotFoundException;

class CreateNewOrder implements CreatesNewOrders
{
    /**
     * Create new order.
     *
     * @param \App\Models\Space $space
     * @param array             $data
     *
     * @return \App\Models\Order
     */
    public function create(Space $space, array $data): Order
    {
        abort_unless($space->isAvailable(), 422);

        return DB::transaction(function () use ($space, $data) {
            $space->update(['reserved_at' => now()]);

            return $space->order()->create(array_merge($data, [
                'user_id' => $space->user_id,
                'confirmation_number' => $this->generateConfirmationNumber(),
            ], static::charges()));
        });
    }

    /**
     * Generate a unique confirmation number.
     *
     * @return string
     */
    protected function generateConfirmationNumber(): string
    {
        $generator = new UidGenerator();

        $generator->setOptions([
            'type' => 'orderConfirmationNumber',
            'parameters' => null,
        ]);

        return $generator->generate();
    }

    /**
     * Get all pre-calculated charges.
     *
     * @return array
     */
    protected static function charges(): array
    {
        if (cache()->has('charges')) {
            return cache()->get('charges');
        }

        throw new ChargesNotFoundException('Charges have not been calculated');
    }
}
