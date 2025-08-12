<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Actions;

use App\Models\User;
use Filament\Actions\Action;

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

            if (auth()->user()->is($record)) {
                return false;
            }

            return auth()->user()->isAdmin() || auth()->user()->isCoordinator();
        });

        $this->label(__('user.action.deactivate'));

        $this->color('danger');

        $this->icon('heroicon-m-no-symbol');

        $this->modalHeading(__('user.action_deactivate_confirm.title'));

        $this->modalSubheading(__('user.action_deactivate_confirm.text'));

        $this->modalButton(__('user.action_deactivate_confirm.action'));

        $this->modalWidth('md');

        $this->action(function (User $record) {
            $record->deactivate();
            $this->success();
        });

        $this->successNotificationTitle(__('user.action_deactivate_confirm.success'));
    }
}
