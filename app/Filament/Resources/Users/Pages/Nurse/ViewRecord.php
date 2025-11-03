<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages\Nurse;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\Users\Actions\ActivateUserAction;
use App\Filament\Resources\Users\Actions\DeactivateUserAction;
use App\Filament\Resources\Users\Actions\ResendInvitationAction;
use App\Filament\Resources\Users\Concerns\HasTabs;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord as BaseViewRecord;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;

abstract class ViewRecord extends BaseViewRecord implements WithTabs
{
    use HasTabs;

    protected static string $resource = UserResource::class;

    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        abort_unless($this->getRecord()->isNurse(), 403);
    }

    public function mount(int | string $record): void
    {
        parent::mount($record);

        $this->callHook('beforeFill');
    }

    protected function getHeaderActions(): array
    {
        $name = "{$this->getActiveTab()}.edit";

        return [
            ActionGroup::make([])
                ->label(__('user.action.manage_profile'))
                ->color('warning')
                ->button()
                ->icon(Heroicon::OutlinedChevronDown)
                ->iconPosition(IconPosition::After)
                ->actions([
                    ResendInvitationAction::make(),

                    EditAction::make()
                        ->icon(Heroicon::Pencil)
                        ->url(fn (User $record) => UserResource::getUrl($name, ['record' => $record]))
                        ->visible(fn (User $record) => auth()->user()->can('update', $record)),

                    ActivateUserAction::make(),

                    DeactivateUserAction::make(),

                    DeleteAction::make()
                        ->icon(Heroicon::Trash),
                ]),
        ];
    }

    public function getTitle(): string
    {
        return $this->getRecord()->full_name;
    }
}
