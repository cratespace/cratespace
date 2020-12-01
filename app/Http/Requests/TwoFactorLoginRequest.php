<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Contracts\Auth\TwoFactorAuthenticator;
use App\Http\Requests\Concerns\ValidatesInput;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class TwoFactorLoginRequest extends FormRequest
{
    use ValidatesInput;

    /**
     * The user attempting the two factor challenge.
     *
     * @var mixed
     */
    protected $challengedUser;

    /**
     * Indicates if the user wished to be remembered after login.
     *
     * @var bool
     */
    protected $remember;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getRulesFor('tfa_signin');
    }

    /**
     * Determine if the request has a valid two factor code.
     *
     * @return bool
     */
    public function hasValidCode(): bool
    {
        return $this->code && app(TwoFactorAuthenticator::class)->verify(
            decrypt($this->challengedUser()->two_factor_secret), $this->code
        );
    }

    /**
     * Get the valid recovery code if one exists on the request.
     *
     * @return string|null
     */
    public function validRecoveryCode(): ?string
    {
        if (!$this->recovery_code) {
            return null;
        }

        return collect($this->challengedUser()->recoveryCodes())->first(function ($code) {
            return hash_equals($this->recovery_code, $code) ? $code : null;
        });
    }

    /**
     * Get the user that is attempting the two factor challenge.
     *
     * @return mixed
     */
    public function challengedUser()
    {
        if ($this->challengedUser) {
            return $this->challengedUser;
        }

        $model = app(StatefulGuard::class)->getProvider()->getModel();

        if (!$this->session()->has('login.id') ||
            !$user = $model::find($this->session()->pull('login.id'))) {
            throw new HttpResponseException($this->failedTwoFactorLoginResponse());
        }

        return $this->challengedUser = $user;
    }

    /**
     * Invalid TFA authentication code response.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function failedTwoFactorLoginResponse(): Response
    {
        $message = __('The provided two factor authentication code was invalid.');

        if ($this->wantsJson()) {
            throw ValidationException::withMessages(['code' => [$message]]);
        }

        return redirect()->route('signin')->withErrors(['email' => $message]);
    }

    /**
     * Determine if the user wanted to be remembered after login.
     *
     * @return bool
     */
    public function remember(): bool
    {
        if (!$this->remember) {
            $this->remember = $this->session()->pull('login.remember', false);
        }

        return $this->remember;
    }
}
