<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Concerns\ResolvesCurrentUserProfile;
use App\Filament\Resources\ProfileResource;
use Filament\Resources\Pages\EditRecord as BaseEditRecord;
use Illuminate\Support\Str;
use Illuminate\View\View;

abstract class EditRecord extends BaseEditRecord
{
    use ResolvesCurrentUserProfile;

    protected static string $view = 'filament::resources.profile.edit';

    protected static string $resource = ProfileResource::class;

    protected function getActions(): array
    {
        return [];
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
        return $this->getResource()::getUrl("{$this->getActiveSection()}.view");
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
