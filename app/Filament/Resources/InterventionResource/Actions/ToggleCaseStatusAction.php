<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Actions;

use App\Filament\Resources\BeneficiaryResource;
use App\Models\Intervention;
use Filament\Pages\Actions\Action;

class ToggleCaseStatusAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'toggle_status';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(
            fn (Intervention $record) => $record->isOpen()
                ? __('intervention.action.close')
                : __('intervention.action.reopen')
        );

        $this->icon(
            fn (Intervention $record) => $record->isOpen()
                ? 'heroicon-s-check-circle'
                : null
        );

        $this->color(
            fn (Intervention $record) => $record->isOpen()
                ? 'warning'
                : 'primary'
        );

        $this->modalHeading(
            fn (Intervention $record) => $record->isOpen()
                ? __('intervention.action_close_confirm.title')
                : __('intervention.action_reopen_confirm.title')
        );
        $this->modalSubheading(
            fn (Intervention $record) => $record->isOpen()
                ? __('intervention.action_close_confirm.text')
                : __('intervention.action_reopen_confirm.text')
        );
        $this->modalButton(
            fn (Intervention $record) => $record->isOpen()
                ? __('intervention.action_close_confirm.action')
                : __('intervention.action_reopen_confirm.action')
        );
        $this->modalWidth('md');
        $this->centerModal(false);

        $this->action(function (Intervention $record) {
            if ($record->isOpen()) {
                $record->close();
            } else {
                $record->open();
            }

            $this->success();
        });

        $this->successNotificationTitle(
            fn (Intervention $record) => $record->isOpen()
                ? __('intervention.action_reopen_confirm.success')
                : __('intervention.action_close_confirm.success')
        );

        $this->successRedirectUrl(function (Intervention $record) {
            return BeneficiaryResource::getUrl('interventions.view', [
                'beneficiary' => $record->beneficiary,
                'record' => $record,
            ]);
        });
    }
}
