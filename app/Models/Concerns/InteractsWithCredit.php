<?php

namespace App\Models\Concerns;

use InvalidArgumentException;

trait InteractsWithCredit
{
    /**
     * Add credit to business.
     *
     * @param int $credit
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function addCredit(int $credit): void
    {
        if ($credit >= 0) {
            $this->updateCredit($credit);

            return;
        }

        throw new InvalidArgumentException('Credit amount should be positive when ~adding~ to account');
    }

    /**
     * Add credit to business.
     *
     * @param int $credit
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function deductCredit(int $credit): void
    {
        if ($credit < 0) {
            $this->updateCredit($credit);

            return;
        }

        throw new InvalidArgumentException('Credit amount should be negative when ~deducting~ to account');
    }

    /**
     * Update user credit amount.
     *
     * @param int $credit
     *
     * @return void
     */
    protected function updateCredit(int $credit): void
    {
        $this->update(['credit' => $credit]);
    }
}
