<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Concerns\ResolvesCurrentUserProfile;
use App\Filament\Resources\ProfileResource;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord as BaseViewRecord;
use Illuminate\Support\Str;

abstract class ViewRecord extends BaseViewRecord
{
    use ResolvesCurrentUserProfile;

    protected static string $view = 'filament::resources.profile.view';

    protected static string $resource = ProfileResource::class;

    protected function getActions(): array
    {
        return [
            EditAction::make()
                ->icon('heroicon-s-pencil')
                ->url($this->getResource()::getUrl("{$this->getActiveSection()}.edit")),
        ];
    }

    protected function getSections(): array
    {
        return $this->getResource()::getProfileSections();
    }

    protected function getActiveSection(): string
    {
        return Str::of(static::class)
            ->classBasename()
            ->kebab()
            ->explode('-')
            ->last();
    }
}
