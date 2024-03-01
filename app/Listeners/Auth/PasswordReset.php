<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\PasswordReset as Event;
use Illuminate\Support\Facades\Log;

class PasswordReset
{
    public function handle(Event $event): void
    {
        Log::info("[PasswordReset] User {$event->user->email} password reset");
    }
}
