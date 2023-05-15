<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use App\Models\Intervention\CaseManagement;
use Filament\Pages\Actions\Action;

class ToggleCaseManagementStatusAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'toggle_status';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(
            fn (CaseManagement $record) => $record->isOpen()
                ? __('intervention.action.close')
                : __('intervention.action.reopen')
        );

        $this->icon(
            fn (CaseManagement $record) => $record->isOpen()
                ? 'heroicon-s-check-circle'
                : null
        );

        $this->color(
            fn (CaseManagement $record) => $record->isOpen()
                ? 'warning'
                : 'primary'
        );

        $this->modalHeading(__('intervention.action_close_confirm.title'));
        $this->modalSubheading(__('intervention.action_close_confirm.text'));
        $this->modalButton(__('intervention.action_close_confirm.action'));
        $this->modalWidth('md');
        $this->centerModal(false);

        $this->action(function (CaseManagement $record) {
            $record->close();

            $this->success();
        });

        $this->successNotificationTitle(__('beneficiary.action_convert.success'));
    }
}
