<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Login as Event;
use Illuminate\Support\Facades\Log;

class Login
{
    public function handle(Event $event): void
    {
        Log::info("[Login] User {$event->user->email} logged in");
    }
}
