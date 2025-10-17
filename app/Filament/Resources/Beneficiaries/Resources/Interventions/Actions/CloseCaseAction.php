<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Actions;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Models\Intervention;
use Filament\Actions\Action;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;

class CloseCaseAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'open';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('intervention.action.close'));
        $this->color('warning');

        $this->icon(Heroicon::OutlinedCheckCircle);

        $this->modalHeading(__('intervention.action_close_confirm.title'));
        $this->modalDescription(__('intervention.action_close_confirm.text'));
        $this->modalSubmitActionLabel(__('intervention.action_close_confirm.action'));
        $this->modalWidth(Width::Medium);

        $this->action(function (Intervention $record) {
            $record->close();

            $this->success();
        });

        $this->successNotificationTitle(__('intervention.action_close_confirm.success'));

        $this->successRedirectUrl(function (Intervention $record) {
            return BeneficiaryResource::getUrl('interventions.view', [
                'beneficiary' => $record->beneficiary,
                'record' => $record,
            ]);
        });
    }
}
