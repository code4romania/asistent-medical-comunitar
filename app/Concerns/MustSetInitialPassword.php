<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Notifications\WelcomeNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait MustSetInitialPassword
{
    protected static function bootMustSetInitialPassword(): void
    {
        static::creating(function (self $user) {
            if (! $user->password) {
                $user->password = Hash::make(Str::random(128));
            }
        });

        static::created(function (self $user) {
            if (! app()->runningInConsole()) {
                $user->sendWelcomeNotification();
            }
        });
    }

    public function hasSetPassword(): bool
    {
        return ! \is_null($this->password_set_at);
    }

    public function markPasswordAsSet(): bool
    {
        return $this->forceFill([
            'password_set_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function sendWelcomeNotification(): void
    {
        $this->notify(new WelcomeNotification);
    }
}
