<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Login as Event;

class Login
{
    public function handle(Event $event): void
    {
        activity('auth')
            ->performedOn($event->user)
            ->event('login')
            ->log('login');
    }
}
