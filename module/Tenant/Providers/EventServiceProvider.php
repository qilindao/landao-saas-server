<?php

namespace Module\Tenant\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Module\Tenant\Listeners\User\UserEventSubscriber;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [];
    /**
     * 注册事件订阅者
     * @var string[]
     */
    protected $subscribe = [
        UserEventSubscriber::class//注册用户事件订阅者
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
