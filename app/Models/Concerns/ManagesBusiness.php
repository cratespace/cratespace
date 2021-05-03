<?php

namespace App\Models\Concerns;

use App\Models\Payout;
use App\Models\Business;
use App\Models\Invitation;
use BadMethodCallException;
use App\Exceptions\InvitationException;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait ManagesBusiness
{
    /**
     * Determine if the user is a business.
     *
     * @return bool
     */
    public function isBusiness(): bool
    {
        return ! is_null($this->business) && ! is_null($this->businessId());
    }

    /**
     * Get user business profile details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function business(): HasOne
    {
        return $this->hasOne(Business::class, 'user_id');
    }

    /**
     * Get the user business registration number.
     *
     * @return string
     */
    public function businessId(): string
    {
        return $this->business->registration_number;
    }

    /**
     * Get where the user business is base in.
     *
     * @return string
     */
    public function base(): string
    {
        return $this->address->country;
    }

    /**
     * Invite the business user to Cratesapce.
     *
     * @return \App\Models\Invitation
     *
     * @throws \App\Exceptions\InvitationException
     */
    public function invite(): Invitation
    {
        if ($this->invited()) {
            throw new InvitationException('This user has already been invited');
        }

        return $this->invitation()->create(['email' => $this->email]);
    }

    /**
     * Determine wether the user has already been invited.
     *
     * @return bool
     */
    public function invited(): bool
    {
        return $this->invitation()->exists() ||
            optional($this->invitation)->accepted;
    }

    /**
     * Get the invitation sent to the business user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invitation(): HasOne
    {
        return $this->hasOne(Invitation::class, 'user_id');
    }

    /**
     * Get the credit amount that belongs to the business.
     *
     * @return int
     *
     * @throws \BadMethodCallException
     */
    public function getCreditAttribute(): int
    {
        if ($this->hasRole('Customer')) {
            throw new BadMethodCallException('User is a customer');
        }

        return $this->payouts()->pluck('amount')->sum();
    }

    /**
     * Make new payout to the user.
     *
     * @param array $details
     *
     * @return \App\Models\Payout
     */
    public function makePayout(array $details): Payout
    {
        return $this->payouts()->create($details);
    }

    /**
     * Get user payouts details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payouts(): HasMany
    {
        return $this->hasMany(Payout::class, 'user_id');
    }
}
