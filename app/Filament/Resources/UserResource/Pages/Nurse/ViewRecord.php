<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages\Nurse;

use App\Contracts\Pages\WithTabs;
use App\Filament\Actions\ActionGroup;
use App\Filament\Resources\ProfileResource\Concerns\HasTabs;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Actions\ActivateUserAction;
use App\Filament\Resources\UserResource\Actions\DeactivateUserAction;
use App\Filament\Resources\UserResource\Actions\ResendInvitationAction;
use App\Filament\Resources\UserResource\Concerns;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord as BaseViewRecord;

abstract class ViewRecord extends BaseViewRecord implements WithTabs
{
    use HasTabs;
    use Concerns\ResolvesRecord;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        $name = "{$this->getActiveTab()}.edit";

        return [
            ActionGroup::make([
                ResendInvitationAction::make()
                    ->record($this->getRecord()),

                EditAction::make()
                    ->icon('heroicon-s-pencil')
                    ->url(fn (User $record) => UserResource::getUrl($name, ['record' => $record]))
                    ->visible(fn (User $record) => auth()->user()->can('update', $record)),

                ActivateUserAction::make()
                    ->record($this->getRecord()),

                DeactivateUserAction::make()
                    ->record($this->getRecord()),

                DeleteAction::make()
                    ->icon('heroicon-s-trash'),
            ])
                ->label(__('user.action.manage_profile')),
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
