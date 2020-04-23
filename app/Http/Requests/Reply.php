<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\ValidationRules;
use App\Http\Requests\Traits\CheckAuthorization;

class Reply extends FormRequest
{
    use ValidationRules;
    use CheckAuthorization;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
<<<<<<< HEAD
        $resource = $this->reply;

        if ($resource) {
=======
        if ($resource = $this->reply) {
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
            return $this->resourceBelongsToUser($resource);
        }

        return $this->authenticated();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => ['required', 'string'],
        ];
    }
}
