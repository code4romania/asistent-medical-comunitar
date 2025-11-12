<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Actions;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Support\Icons\Heroicon;

class DeactivateUserAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'deactivate';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(function (User $record) {
            if ($record->isInactive()) {
                return false;
            }

            if (Filament::auth()->user()->is($record)) {
                return false;
            }

            return Filament::auth()->user()->isAdmin()
                || Filament::auth()->user()->isCoordinator();
        });

        $this->label(__('user.action.deactivate'));

        $this->color('danger');

        $this->icon(Heroicon::NoSymbol);

        $this->modalHeading(__('user.action_deactivate_confirm.title'));

        $this->modalDescription(__('user.action_deactivate_confirm.text'));

        $this->modalSubmitActionLabel(__('user.action_deactivate_confirm.action'));

        $this->action(function (User $record) {
            $record->deactivate();
            $this->success();
        });

        $this->successNotificationTitle(__('user.action_deactivate_confirm.success'));
    }
}
