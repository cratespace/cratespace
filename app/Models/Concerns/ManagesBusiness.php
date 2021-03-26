<?php

namespace App\Models\Concerns;

use App\Models\Business;
use App\Models\Invitation;
use App\Events\BusinessInvited;
use App\Exceptions\UserAlreadyOnboard;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait ManagesBusiness
{
    /**
     * Create user as customer type account.
     *
     * @param array|null $data
     *
     * @return void
     */
    public function createAsBusiness(?array $data = null): void
    {
        Business::create([
            'user_id' => $this->id,
            'type' => 'standard',
            'name' => $data['business'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'registration_number' => $data['registration_number'],
            'business_type' => 'company',
            'business_profile' => [
                'name' => $data['business'],
                'mcc' => $data['mcc'] ?? null,
                'support_phone' => $data['phone'],
                'support_email' => $data['email'],
                'url' => $data['url'] ?? null,
            ],
        ]);
    }

    /**
     * Invite the business user to Cratesapce.
     *
     * @return \App\Models\Invitation
     *
     * @throws \App\Exceptions\UserAlreadyOnboard
     */
    public function invite(): Invitation
    {
        if ($this->invited()) {
            throw new UserAlreadyOnboard('This user has already been invited');
        }

        $invitation = $this->invitation()->create(['email' => $this->email]);

        BusinessInvited::dispatch($invitation);

        return $invitation;
    }

    /**
     * Determine wether the user has already been invited.
     *
     * @return bool
     */
    public function invited(): bool
    {
        return $this->invitation()->exists() || optional($this->invitation)->accepted;
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
     * Get user business profile details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function business(): HasOne
    {
        return $this->hasOne(Business::class, 'user_id');
    }
}
