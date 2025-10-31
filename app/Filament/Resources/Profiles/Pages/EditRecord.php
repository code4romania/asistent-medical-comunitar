<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\Profiles\Concerns\HasTabs;
use App\Filament\Resources\Profiles\Concerns\ResolvesRecord;
use App\Filament\Resources\Profiles\ProfileResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord as BaseEditRecord;
use Filament\Support\Icons\Heroicon;

abstract class EditRecord extends BaseEditRecord implements WithTabs
{
    use HasTabs;
    use ResolvesRecord;

    protected static string $resource = ProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [];
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

    protected function getRedirectUrl(): string
    {
        return $this->getPageUrl("{$this->getActiveTab()}.view");
    }

    protected function getFormActions(): array
    {
        return [

            $this->getSaveFormAction()
                ->icon(Heroicon::OutlinedCheck),

            Action::make('cancel')
                ->label(__('filament::resources/pages/edit-record.form.actions.cancel.label'))
                ->url($this->previousUrl ?? $this->getRedirectUrl())
                ->color('gray'),
        ];
    }

    public function getRelationManagers(): array
    {
        return [];
    }
}
