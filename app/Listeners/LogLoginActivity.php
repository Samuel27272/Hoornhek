<?php

namespace App\Listeners;

use App\Models\LoginLog;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class LogLoginActivity
{
    public function onLogin(Login $event): void
    {
        LoginLog::create([
            'user_id' => $event->user->id,
            'email'   => $event->user->email,
            'event'   => 'login',
        ]);
    }

    public function onLogout(Logout $event): void
    {
        LoginLog::create([
            'user_id' => $event->user?->id,
            'email'   => $event->user?->email,
            'event'   => 'logout',
        ]);
    }

    public function onFailed(Failed $event): void
    {
        LoginLog::create([
            'user_id' => $event->user?->id,
            'email'   => $event->credentials['email'] ?? null,
            'event'   => 'failed',
        ]);
    }
}
