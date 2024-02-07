<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages\Nurse;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Concerns;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord as BaseViewRecord;

class ViewRecord extends BaseViewRecord implements WithTabs
{
    use Concerns\HasTabs;
    use Concerns\ResolvesRecord;

    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        $name = "{$this->getActiveTab()}.edit";

        return [
            EditAction::make()
                ->icon('heroicon-s-pencil')
                ->url(fn ($record) => UserResource::getUrl($name, $record))
                ->visible(fn ($record) => auth()->user()->can('update', $record)),
        ];
    }

    protected function getTitle(): string
    {
        return $this->isOwnProfile
            ? __('user.profile.my_profile')
            : $this->getRecord()->full_name;
    }

    protected function getBreadcrumbs(): array
    {
        return [
            auth()->user()->getFilamentName(),
        ];
    }
}
