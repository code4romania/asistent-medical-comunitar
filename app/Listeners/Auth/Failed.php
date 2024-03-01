<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Failed as Event;
use Illuminate\Support\Facades\Log;

class Failed
{
    public function handle(Event $event): void
    {
        Log::info("[Failed] User {$event->credentials['email']} login failed");
    }
}
