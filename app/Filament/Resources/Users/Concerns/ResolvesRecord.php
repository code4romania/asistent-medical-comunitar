<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Concerns;

use App\Filament\Resources\Users\UserResource;

trait ResolvesRecord
{
    protected bool $isOwnProfile = false;

    public function getPageUrl(string $name): string
    {
        return UserResource::getUrl($name, [
            'record' => $this->getRecord(),
        ]);
    }
}
