<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\ProfileResource;
use App\Filament\Resources\ProfileResource\Concerns;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord as BaseEditRecord;
use Illuminate\View\View;

class EditRecord extends BaseEditRecord implements WithTabs
{
    use Concerns\HasTabs;
    use Concerns\ResolvesRecord;

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

            Action::make('cancel')
                ->label(__('filament::resources/pages/edit-record.form.actions.cancel.label'))
                ->url($this->previousUrl ?? $this->getRedirectUrl())
                ->color('secondary'),
        ];
    }

    protected function getRelationManagers(): array
    {
        return [];
    }
}
