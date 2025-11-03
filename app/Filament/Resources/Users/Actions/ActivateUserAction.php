<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Actions;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Support\Icons\Heroicon;

class ActivateUserAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'activate';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(function (User $record) {
            if ($record->isActive()) {
                return false;
            }

            if (Filament::auth()->user()->is($record)) {
                return false;
            }

            return Filament::auth()->user()->isAdmin()
                || Filament::auth()->user()->isCoordinator();
        });

        $this->label(__('user.action.activate'));

        $this->color('success');

        $this->icon(Heroicon::CheckBadge);

        $this->modalHeading(__('user.action_activate_confirm.title'));

        $this->modalDescription(__('user.action_activate_confirm.text'));

        $this->modalSubmitActionLabel(__('user.action_activate_confirm.action'));

        $this->action(function (User $record) {
            $record->activate();
            $this->success();
        });

        $this->successNotificationTitle(__('user.action_activate_confirm.success'));
    }
}
