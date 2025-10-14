<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Actions;

use App\Enums\Beneficiary\Type;
use App\Enums\Intervention\CaseInitiator;
use App\Enums\Intervention\Status;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Models\Beneficiary;
use App\Models\Intervention\InterventionableCase;
use App\Models\Intervention\InterventionableIndividualService;
use App\Models\Intervention\OcasionalIntervention;
use App\Models\Service\Service;
use Filament\Actions\Action;
use Filament\Support\Enums\Width;

class ConvertOcasionalBeneficiaryAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'convert';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(fn (Beneficiary $record) => $record->isOcasional());

        $this->label(__('beneficiary.action_convert.action'));

        $this->modalHeading(__('beneficiary.action_convert_confirm.title'));
        $this->modalDescription(__('beneficiary.action_convert_confirm.text'));
        $this->modalSubmitActionLabel(__('beneficiary.action_convert_confirm.action'));
        $this->modalWidth(Width::Medium);

        $this->color('gray');

        $this->action(function (Beneficiary $record) {
            $record->update([
                'type' => Type::REGULAR,
            ]);

            $record
                ->ocasionalInterventions()
                ->with('services')
                ->get()
                ->map(function (OcasionalIntervention $ocasionalIntervention) use ($record) {
                    $interventionable = InterventionableCase::create([
                        'name' => $ocasionalIntervention->reason,
                        'initiator' => CaseInitiator::NURSE,
                        'is_imported' => true,
                    ]);

                    $case = $interventionable->intervention()->create([
                        'closed_at' => now(),
                        'beneficiary_id' => $record->id,
                        'vulnerability_id' => 'NONE',
                    ]);

                    $ocasionalIntervention->services
                        ->each(function (Service $service) use ($ocasionalIntervention, $case) {
                            $interventionable = InterventionableIndividualService::create([
                                'service_id' => $service->id,
                                'date' => $ocasionalIntervention->date,
                                'status' => Status::REALIZED,
                            ]);

                            $interventionable->intervention()->create([
                                'parent_id' => $case->id,
                                'beneficiary_id' => $case->beneficiary_id,
                            ]);
                        });

                    $ocasionalIntervention->delete();
                });

            $this->success();
        });

        $this->successNotificationTitle(__('beneficiary.action_convert.success'));
        $this->successRedirectUrl(fn (Beneficiary $record) => BeneficiaryResource::getUrl('view', [
            'record' => $record,
        ]));
    }
}
