<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\ProfileResource;
use App\Filament\Resources\ProfileResource\Concerns;
use App\Filament\Resources\UserResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord as BaseViewRecord;

class ViewRecord extends BaseViewRecord implements WithTabs
{
    use Concerns\HasTabs;
    use Concerns\ResolvesRecord;

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
