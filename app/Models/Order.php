<?php

namespace App\Models;

use App\Models\Traits\HasUid;
use Laravel\Scout\Searchable;
use App\Models\Traits\Fillable;
use App\Mail\OrderStatusUpdated;
use App\Models\Traits\Filterable;
use Illuminate\Support\Facades\Mail;
use App\Models\Concerns\GeneratesUid;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Fillable;
    use Filterable;
    use HasUid;
    use Searchable;
    use GeneratesUid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'business', 'status',
        'total', 'tax', 'service', 'user_id', 'space_id',
        'uid', 'payment_type',
    ];

    /**
     * All processes to perform to create a new order.
     *
     * @var array
     */
    protected static $processes = [
        \App\Processes\Orders\Payment::class,
        \App\Processes\Orders\NewOrder::class,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['path'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['space'];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function ($order) {
            if ($order->status !== 'Pending') {
                $order->notifyStatusUpdate();
            }
        });
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'uid' => $this->uid,
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    /**
     * Get the space associated with the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    /**
     * Get the space associated with the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get full path to resource page.
     *
     * @return string
     */
    public function getPathAttribute()
    {
        return $this->path();
    }

    /**
     * Mark the space as expired.
     *
     * @param mixed $status
     */
    public function markAs($status)
    {
        $this->update(['status' => $status]);
    }

    /**
     * Get full path to resource page.
     *
     * @return string
     */
    public function path()
    {
        return "/orders/{$this->uid}";
    }

    /**
     * Process order.
     *
     * @param array $data
     *
     * @return void
     */
    public static function process(array $data)
    {
        foreach (static::$processes as $process) {
            (new $process())->perform($data);
        }
    }

    /**
     * Notify customer of order status update.
     *
     * @return \Illuminate\Support\Facades\Mail
     */
    public function notifyStatusUpdate()
    {
        return Mail::send(new OrderStatusUpdated($this));
    }
}
