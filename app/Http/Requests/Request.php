<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\HasCustomValidator;
use App\Http\Requests\Concerns\AuthorizesRequests;
use App\Http\Requests\Traits\InputValidationRules;

abstract class Request extends FormRequest
{
    use AuthorizesRequests;
    use InputValidationRules;
    use HasCustomValidator;
}
