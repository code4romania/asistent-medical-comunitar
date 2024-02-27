<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Concerns;

use App\Filament\Resources\ProfileResource;

trait ResolvesRecord
{
    protected bool $isOwnProfile = true;

    public function mount($record = null): void
    {
        $this->record = auth()->user();

        if (method_exists($this, 'authorizeAccess')) {
            $this->authorizeAccess();
        }

        $this->fillForm();
    }

    public function getPageUrl(string $name): string
    {
        return ProfileResource::getUrl($name);
    }
}
