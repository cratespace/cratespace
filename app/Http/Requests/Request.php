<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\HasCustomValidator;
use App\Http\Requests\Concerns\AuthorizesRequests;
use App\Http\Requests\Traits\InputValidationRules;

abstract class Request extends FormRequest
{
    use AuthorizesRequests;
    use InputValidationRules;
    use HasCustomValidator;

    /**
     * Handle a passed validation attempt.
     *
     * @param \Closure
     *
     * @return void
     */
    public function tap(Closure $callback): void
    {
        call_user_func($callback, $this->user());
    }
}
