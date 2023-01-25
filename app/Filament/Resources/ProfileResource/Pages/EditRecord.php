<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Concerns\ResolvesCurrentUserProfile;
use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\ProfileResource;
use Filament\Resources\Pages\EditRecord as BaseEditRecord;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EditRecord extends BaseEditRecord implements WithTabs
{
    use ResolvesCurrentUserProfile;

    protected static string $view = 'filament.pages.profile.edit';

    protected static string $resource = ProfileResource::class;

    protected function getActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        return $this->getResource()::getProfileSections();
    }

    public function getActiveTab(): string
    {
        return Str::of(static::class)
            ->classBasename()
            ->kebab()
            ->explode('-')
            ->last();
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
