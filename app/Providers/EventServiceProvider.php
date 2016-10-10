<?php

namespace App\Providers;

use App\Listeners\Order\OrderBalanceEventSubscriber;
use App\Listeners\Order\OrderBonusesEventSubscriber;
use App\Listeners\Order\OrderContactDetailsEventSubscriber;
use App\Listeners\Order\OrderDeliveryEventSubscriber;
use App\Listeners\Order\OrderIndexEventSubscriber;
use App\Listeners\UserBalanceEventSubscriber;
use App\Listeners\UserBonusEventSubscriber;
use App\Listeners\UserEventSubscriber;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];


    protected $subscribe = [
        UserEventSubscriber::class,
        OrderIndexEventSubscriber::class,
        OrderContactDetailsEventSubscriber::class,
        OrderDeliveryEventSubscriber::class,
        OrderBonusesEventSubscriber::class,
        UserBonusEventSubscriber::class,
        UserBalanceEventSubscriber::class,
        OrderBalanceEventSubscriber::class,
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
