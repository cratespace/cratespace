<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Listeners\NotifyBusiness;
use App\Listeners\NotifySubscribers;
use Illuminate\Support\Facades\Event;
use App\Events\ThreadReceivedNewReply;
use Illuminate\Auth\Events\Registered;
use App\Listeners\NotifyMentionedUsers;
use App\Listeners\UpdateBusinessCredit;
use App\Listeners\SendOrderDetailsEmail;
use App\Events\PaymentProcessingSucceeded;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        PaymentProcessingSucceeded::class => [
            UpdateBusinessCredit::class,
        ],

        OrderPlaced::class => [
            NotifyBusiness::class,
            SendOrderDetailsEmail::class,
        ],

        ThreadReceivedNewReply::class => [
            NotifyMentionedUsers::class,
            NotifySubscribers::class,
        ],
    ];
}
