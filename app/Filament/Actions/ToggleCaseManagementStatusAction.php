<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use App\Filament\Resources\BeneficiaryResource;
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

        $this->modalHeading(
            fn (CaseManagement $record) => $record->isOpen()
                ? __('intervention.action_close_confirm.title')
                : __('intervention.action_reopen_confirm.title')
        );
        $this->modalSubheading(
            fn (CaseManagement $record) => $record->isOpen()
                ? __('intervention.action_close_confirm.text')
                : __('intervention.action_reopen_confirm.text')
        );
        $this->modalButton(
            fn (CaseManagement $record) => $record->isOpen()
                ? __('intervention.action_close_confirm.action')
                : __('intervention.action_reopen_confirm.action')
        );
        $this->modalWidth('md');
        $this->centerModal(false);

        $this->action(function (CaseManagement $record) {
            if ($record->isOpen()) {
                $record->close();
            } else {
                $record->open();
            }

            $this->success();
        });

        $this->successNotificationTitle(
            fn (CaseManagement $record) => $record->isOpen()
                ? __('intervention.action_reopen_confirm.success')
                : __('intervention.action_close_confirm.success')
        );

        $this->successRedirectUrl(function (CaseManagement $record) {
            return BeneficiaryResource::getUrl('interventions.view', [
                'record' => $record->beneficiary,
                'intervention' => $record,
            ]);
        });
    }
}
