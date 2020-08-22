<?php

namespace App\Models;

use InvalidArgumentException;
use App\Models\Concerns\ManagesStatus;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use ManagesStatus;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'priority',
        'status',
        'message',
        'attachment',
        'user_id',
        'agent_id',
    ];

    /**
     * Assign ticket to support agent.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    public function assignTo(User $user): bool
    {
        if ($user->hasRole('support-agent')) {
            return $this->update(['agent_id' => $user->id]);
        }

        throw new InvalidArgumentException("Given user does not have 'Support Agent' role.");
    }

    /**
     * Get the user the support ticket belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the agent assigned to the support ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
