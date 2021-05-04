<?php

namespace App\Models;

use App\Casts\DimensionsCast;
use App\Models\Casts\ScheduleCast;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasEncryptableCode;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Space extends Model
{
    use HasFactory;
    use HasEncryptableCode;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'user_id',
        'dimensions',
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
        'reserved_at' => 'datetime',
        'departs_at' => 'datetime',
        'arrives_at' => 'datetime',
        'schedule' => ScheduleCast::class,
        'dimensions' => DimensionsCast::class,
    ];

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
}
