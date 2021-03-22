<?php

namespace App\Models\Concerns;

use App\Support\Util;
use App\Models\Business;
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
            'country' => Util::alpha2($data['country']),
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
     * Get user business profile details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function business(): HasOne
    {
        return $this->hasOne(Business::class, 'user_id');
    }
}
