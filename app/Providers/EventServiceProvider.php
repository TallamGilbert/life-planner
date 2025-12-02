<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\LogAuthenticationEvents;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            LogAuthenticationEvents::class . '@handleLogin',
        ],
        Logout::class => [
            LogAuthenticationEvents::class . '@handleLogout',
        ],
    ];
}