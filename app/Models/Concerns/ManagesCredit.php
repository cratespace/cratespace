<?php

namespace App\Models\Concerns;

trait ManagesCredit
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
        $this->updateCredit(abs($credit));
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
        $this->updateCredit(-1 * abs($credit));
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
