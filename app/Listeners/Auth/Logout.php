<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Logout as Event;

class Logout
{
    public function handle(Event $event): void
    {
        activity('auth')
            ->performedOn($event->user)
            ->event('logout')
            ->log('logout');
    }
}
