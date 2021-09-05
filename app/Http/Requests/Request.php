<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\AuthorizesRequests;
use App\Http\Requests\Traits\HasCustomValidator;
use App\Support\Concerns\InteractsWithContainer;
use Emberfuse\Scorch\Http\Requests\Traits\InputValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Traits\Tappable;

abstract class Request extends FormRequest
{
    use AuthorizesRequests;
    use InputValidationRules;
    use HasCustomValidator;
    use InteractsWithContainer;
    use Tappable;
}
