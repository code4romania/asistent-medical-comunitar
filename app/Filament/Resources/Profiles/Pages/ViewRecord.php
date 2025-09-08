<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Resources\Profiles\Concerns\HasTabs;
use App\Filament\Resources\Profiles\Concerns\ResolvesRecord;
use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\Profiles\ProfileResource;
use App\Filament\Resources\ProfileResource\Concerns;
use App\Filament\Resources\Users\UserResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord as BaseViewRecord;

abstract class ViewRecord extends BaseViewRecord implements WithTabs
{
    use HasTabs;
    use ResolvesRecord;

    protected static string $resource = ProfileResource::class;

    protected function getHeaderActions(): array
    {
        $name = "{$this->getActiveTab()}.edit";

        return [
            EditAction::make()
                ->icon('heroicon-s-pencil')
                ->url(
                    auth()->user()->is($this->getRecord())
                        ? ProfileResource::getUrl($name)
                        : UserResource::getUrl($name, $this->getRecord())
                )
                ->visible(fn ($record) => auth()->user()->can('update', $record)),
        ];
    }

    public function getTitle(): string
    {
        return $this->isOwnProfile
            ? __('user.profile.my_profile')
            : $this->getRecord()->full_name;
    }

    public function getBreadcrumbs(): array
    {
        return [
            auth()->user()->getFilamentName(),
        ];
    }
}
