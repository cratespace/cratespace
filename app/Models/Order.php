<?php

namespace App\Models;

use App\Models\Traits\HasUid;
use Laravel\Scout\Searchable;
use App\Models\Traits\Fillable;
use App\Mail\OrderStatusUpdated;
<<<<<<< HEAD
=======
use App\Models\Traits\Graphable;
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
use App\Models\Traits\Filterable;
use Illuminate\Support\Facades\Mail;
use App\Models\Concerns\GeneratesUid;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
<<<<<<< HEAD
    use Fillable;
    use Filterable;
    use HasUid;
    use Searchable;
    use GeneratesUid;
=======
    use Fillable,
        Filterable,
        HasUid,
        Searchable,
        GeneratesUid;
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951

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
<<<<<<< HEAD
            'email' => $this->email,
=======
            'email' => $this->email
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
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
<<<<<<< HEAD
     *
     * @param mixed $status
=======
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
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
<<<<<<< HEAD
     * @param array $data
     *
=======
     * @param  array  $data
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
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
