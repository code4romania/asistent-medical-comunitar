<?php

declare(strict_types=1);

namespace App\Listeners\Sentry;

use App\Models\User;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Login;
use function Sentry\configureScope;
use Sentry\State\Scope;

class SetUserContext
{
    public function handle(Login | Authenticated $event): void
    {
        /** @var User */
        $user = $event->user;

        if (blank($user)) {
            return;
        }

        configureScope(function (Scope $scope) use ($user) {
            $scope->setUser([
                'id' => $user->getKey(),
            ]);
        });
    }
}
