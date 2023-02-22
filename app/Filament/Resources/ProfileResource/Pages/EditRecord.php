<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Concerns\Profile\Tabs;
use App\Concerns\ResolvesCurrentUserProfile;
use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\ProfileResource;
use Filament\Resources\Pages\EditRecord as BaseEditRecord;
use Illuminate\View\View;

class EditRecord extends BaseEditRecord implements WithTabs
{
    use ResolvesCurrentUserProfile;
    use Tabs;

    protected static string $resource = ProfileResource::class;

    protected function getActions(): array
    {
        return [];
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

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl("{$this->getActiveTab()}.view");
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->icon('heroicon-o-check'),
            $this->getCancelFormAction()
                ->url($this->getRedirectUrl()),
        ];
    }

    protected function getRelationManagers(): array
    {
        return [];
    }
}
