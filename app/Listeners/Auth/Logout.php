<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Logout as Event;
use Illuminate\Support\Facades\Log;

class Logout
{
    public function handle(Event $event): void
    {
        Log::info("[Logout] User {$event->user->email} logged out");
    }
}
