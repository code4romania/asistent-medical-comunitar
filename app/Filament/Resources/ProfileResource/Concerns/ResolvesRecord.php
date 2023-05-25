<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Concerns;

use App\Filament\Resources\ProfileResource;
use App\Filament\Resources\UserResource;

trait ResolvesRecord
{
    public function mount($record = null): void
    {
        if (\is_null($record)) {
            $this->record = auth()->user();

            $this->fillForm();
        } else {
            parent::mount($record);
        }
    }

    public function getPageUrl(string $name): string
    {
        if (auth()->user()->is($this->getRecord())) {
            return ProfileResource::getUrl($name);
        }

        return UserResource::getUrl($name, $this->getRecord());
    }
}
