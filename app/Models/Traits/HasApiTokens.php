<?php

namespace App\Models\Traits;

use Emberfuse\Scorch\Actions\CreateAccessToken;
use Emberfuse\Scorch\API\Tokens\PersonalAccessToken;
use Emberfuse\Scorch\Contracts\Auth\Access;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

trait HasApiTokens
{
    /**
     * The access token the user is using for the current request.
     *
     * @var \Emberfuse\Scorch\Contracts\Auth\Access
     */
    protected $accessToken;

    /**
     * Get the access tokens that belong to model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function tokens(): MorphMany
    {
        return $this->morphMany(PersonalAccessToken::class, 'tokenable');
    }

    /**
     * Determine if the current API token has a given scope.
     *
     * @param string $ability
     *
     * @return bool
     */
    public function tokenCan(string $ability): bool
    {
        return $this->accessToken && $this->accessToken->can($ability);
    }

    /**
     * Create a new personal access token for the user.
     *
     * @param string $name
     * @param array  $abilities
     *
     * @return mixed
     */
    public function createToken(string $name, array $abilities = ['*'])
    {
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
        ]);

        return new CreateAccessToken($token, $token->id . '|' . $plainTextToken);
    }

    /**
     * Get the access token currently associated with the user.
     *
     * @return \Emberfuse\Scorch\Contracts\Auth\Access
     */
    public function currentAccessToken(): Access
    {
        return $this->accessToken;
    }

    /**
     * Set the current access token for the user.
     *
     * @param \Emberfuse\Scorch\Contracts\Auth\Access $accessToken
     *
     * @return $this
     */
    public function withAccessToken(Access $accessToken): Model
    {
        $this->accessToken = $accessToken;

        return $this;
    }
}
