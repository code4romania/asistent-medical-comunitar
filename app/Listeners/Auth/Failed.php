<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Failed as Event;

class Failed
{
    public function handle(Event $event): void
    {
        if (blank($event->user)) {
            return;
        }

        activity('auth')
            ->performedOn($event->user)
            ->event('failed')
            ->log('failed');
    }
}
