<?php

namespace App\Validations;

use App\Contracts\Validations\Validation as ValidationContract;

class PlaceOrderValidation extends Validation implements ValidationContract
{
    /**
     * Get relevant resource for currently accessing resource.
     *
     * @param array $additionalRules
     *
     * @return array
     */
    public function rules(array $additionalRules = []): array
    {
        return $this->getRulesFor('order', $additionalRules);
    }
}
