<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\Profiles\Concerns\HasTabs;
use App\Filament\Resources\Profiles\Concerns\ResolvesRecord;
use App\Filament\Resources\Profiles\ProfileResource;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ViewRecord as BaseViewRecord;
use Filament\Support\Icons\Heroicon;

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
                ->icon(Heroicon::Pencil)
                ->url(ProfileResource::getUrl($name)),
        ];
    }

    public function getTitle(): string
    {
        return __('user.profile.my_profile');
    }

    public function getBreadcrumbs(): array
    {
        return [
            Filament::auth()->user()->getFilamentName(),
        ];
    }
}
