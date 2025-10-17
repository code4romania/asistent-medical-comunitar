<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Actions;

use App\Filament\Resources\Beneficiaries\Resources\Interventions\InterventionResource;
use App\Models\Intervention;
use Filament\Actions\Action;
use Filament\Support\Enums\Width;

class ReopenCaseAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'reopen';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('intervention.action.reopen'));
        $this->color('primary');

        $this->icon(null);

        $this->modalHeading(__('intervention.action_reopen_confirm.title'));
        $this->modalDescription(__('intervention.action_reopen_confirm.text'));
        $this->modalSubmitActionLabel(__('intervention.action_reopen_confirm.action'));
        $this->modalWidth(Width::Medium);

        $this->action(function (Intervention $record) {
            $record->open();

            $this->success();
        });

        $this->successNotificationTitle(__('intervention.action_reopen_confirm.success'));

        $this->successRedirectUrl(function (Intervention $record) {
            return InterventionResource::getUrl('view', [
                'beneficiary' => $record->beneficiary,
                'record' => $record,
            ]);
        });
    }
}
