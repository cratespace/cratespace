<?php

namespace App\Models;

use InvalidArgumentException;
use App\Models\Traits\Mailable;
use App\Models\Traits\Filterable;
use App\Models\Traits\Redirectable;
use App\Mail\TicketStatusUpdatedMail;
use App\Events\TicketReceivedNewReply;
use App\Models\Concerns\ManagesStatus;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use Mailable;
    use ManagesStatus;
    use Redirectable;
    use Filterable;

    /**
     * Preferred route key name.
     *
     * @var string
     */
    protected static $routeKey = 'code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'subject',
        'priority',
        'status',
        'description',
        'attachment',
        'agent_id',
        'user_id',
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
     * Get the customer the support ticket belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the support agent assigned to the support ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Get all replies associated with the support ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Add new reply and associate it with the thread.
     *
     * @param array $data
     *
     * @return \App\Models\Reply
     */
    public function addReply(array $data): Reply
    {
        $reply = $this->replies()->create($data);

        event(new TicketReceivedNewReply($reply));

        return $reply;
    }

    /**
     * Update ticket status.
     *
     * @param string $status
     *
     * @return void
     */
    public function updateStatus(string $status): void
    {
        $this->mark($status);

        $this->mail(TicketStatusUpdatedMail::class, $this->user->email);
    }
}
