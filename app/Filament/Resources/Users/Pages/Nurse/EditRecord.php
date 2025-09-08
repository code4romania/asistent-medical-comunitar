<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages\Nurse;

use App\Filament\Resources\Users\Concerns\ResolvesRecord;
use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\Profiles\Concerns\HasTabs;
use App\Filament\Resources\Users\UserResource;
use App\Filament\Resources\UserResource\Concerns;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord as BaseEditRecord;

class EditRecord extends BaseEditRecord implements WithTabs
{
    use HasTabs;
    use ResolvesRecord;

    protected static string $resource = UserResource::class;

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
                ->icon('heroicon-o-check'),

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
