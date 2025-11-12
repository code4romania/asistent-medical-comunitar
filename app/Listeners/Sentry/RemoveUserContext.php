<?php

declare(strict_types=1);

namespace App\Listeners\Sentry;

use App\Listeners\Auth\Logout;
use Sentry\State\Scope;
use function Sentry\configureScope;

class RemoveUserContext
{
    public function handle(Logout $event): void
    {
        configureScope(function (Scope $scope) {
            $scope->removeUser();
        });
    }
}
