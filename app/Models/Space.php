<?php

namespace App\Models;

use LogicException;
use App\Models\Casts\LocationCast;
use App\Models\Casts\ScheduleCast;
use App\Models\Concerns\ManagesSpace;
use Illuminate\Database\Eloquent\Model;
use Cratespace\Preflight\Models\Traits\Hashable;
use Cratespace\Preflight\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Space extends Model
{
    use Hashable;
    use Filterable;
    use HasFactory;
    use ManagesSpace;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'user_id',
        'height',
        'width',
        'length',
        'weight',
        'note',
        'price',
        'tax',
        'type',
        'base',
        'reserved_at',
        'departs_at',
        'arrives_at',
        'origin',
        'destination',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tax' => 'integer',
        'price' => 'integer',
        'origin' => LocationCast::class,
        'destination' => LocationCast::class,
        'reserved_at' => 'datetime',
        'departs_at' => 'datetime',
        'arrives_at' => 'datetime',
        'schedule' => ScheduleCast::class,
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'code';
    }

    /**
     * Get the business the space belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Attach a note to this space.
     *
     * @param string $note
     *
     * @return void
     */
    public function attachNote(string $note): void
    {
        $this->forceFill(['note' => $note])->save();
    }

    /**
     * Determine if the space has a valid schedule.
     *
     * @return bool|null
     */
    public function validateSchedule(): ?bool
    {
        if ($this->departs_at->isBefore($this->arrives_at)) {
            return true;
        }

        throw new LogicException('Departure date should be before arrival date');
    }

    /**
     * Get the full path to the resource.
     *
     * @return string
     */
    public function path(): string
    {
        return route('spaces.show', $this);
    }
}
