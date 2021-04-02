<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Contracts\Billing\Order;
use Illuminate\Notifications\Notification;
use App\Mail\NewOrderPlaced as NewOrderPlacedMailable;

class NewOrderPlaced extends Notification
{
    use Queueable;

    /**
     * The instance of the order.
     *
     * @var \App\Contracts\Billing\Order
     */
    protected $order;

    /**
     * Create a new notification instance.
     *
     * @param \App\Contracts\Billing\Order $order
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->settings->notifications;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new NewOrderPlacedMailable($this->order))
            ->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'New order placed',
            'order' => route('orders.show', $this->order),
        ];
    }
}
