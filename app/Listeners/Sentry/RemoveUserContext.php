<?php

declare(strict_types=1);

namespace App\Listeners\Sentry;

use App\Listeners\Auth\Logout;
use function Sentry\configureScope;
use Sentry\State\Scope;

class RemoveUserContext
{
    public function handle(Logout $event): void
    {
        configureScope(function (Scope $scope) {
            $scope->removeUser();
        });
    }
}
