<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\PasswordReset as Event;

class PasswordReset
{
    public function handle(Event $event): void
    {
        activity('auth')
            ->performedOn($event->user)
            ->event('password reset')
            ->log('password reset');
    }
}
