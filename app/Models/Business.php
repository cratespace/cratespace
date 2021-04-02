<?php

namespace App\Models;

use App\Models\Casts\ProfileCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Cratespace\Sentinel\Models\Traits\HasProfilePhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Business extends Model
{
    use HasFactory;
    use HasProfilePhoto;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $fillable = [
        'user_id',
        'type',
        'name',
        'email',
        'phone',
        'registration_number',
        'country',
        'business_type',
        'profile_photo_path',
        'business_profile',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'business_profile' => ProfileCast::class,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['profile_photo_url'];

    /**
     * Get the user this profile belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Find the business with the given registration number.
     *
     * @param string $number
     *
     * @return \App\Models\Business
     */
    public static function findUsingRegistrationNumber(string $number): Business
    {
        return static::where('registration_number', $number)->firstOrFail();
    }
}
