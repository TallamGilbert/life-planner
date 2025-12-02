<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class LogAuthenticationEvents
{
    public function handleLogin(Login $event)
    {
        ActivityLog::log(
            'login',
            'User logged in',
            'User',
            $event->user->id
        );
    }

    public function handleLogout(Logout $event)
    {
        ActivityLog::log(
            'logout',
            'User logged out',
            'User',
            $event->user->id ?? null
        );
    }
}