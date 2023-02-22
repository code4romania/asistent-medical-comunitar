<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Concerns\Profile\Tabs;
use App\Concerns\ResolvesCurrentUserProfile;
use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\ProfileResource;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord as BaseViewRecord;
use Illuminate\View\View;

class ViewRecord extends BaseViewRecord implements WithTabs
{
    use ResolvesCurrentUserProfile;
    use Tabs;

    protected static string $resource = ProfileResource::class;

    protected function getActions(): array
    {
        return [
            EditAction::make()
                ->icon('heroicon-s-pencil')
                ->url($this->getResource()::getUrl("{$this->getActiveTab()}.edit")),
        ];
    }

    protected function getHeader(): View
    {
        return view('profile.header');
    }

    protected function getBreadcrumbs(): array
    {
        return [
            auth()->user()->getFilamentName(),
        ];
    }
}
