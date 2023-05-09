<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use App\Enums\Beneficiary\Type;
use App\Enums\Intervention\CaseInitiator;
use App\Enums\Intervention\CaseType;
use App\Filament\Resources\BeneficiaryResource;
use App\Models\Beneficiary;
use App\Models\Intervention\OcasionalIntervention;
use App\Models\Service\Service;
use Filament\Pages\Actions\Action;

class ConvertOcasionalBeneficiaryAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'convert_beneficiary_type';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(fn () => $this->getRecord()->isOcasional());

        $this->label(__('beneficiary.action_convert.action'));

        $this->modalHeading(__('beneficiary.action_convert_confirm.title'));
        $this->modalSubheading(__('beneficiary.action_convert_confirm.text'));
        $this->modalButton(__('beneficiary.action_convert_confirm.action'));
        $this->modalWidth('md');
        $this->centerModal(false);

        $this->color('secondary');

        $this->action(function () {
            /** @var Beneficiary */
            $beneficiary = $this->getRecord();

            $beneficiary->ocasionalInterventions()
                ->with('services')
                ->get()
                ->map(function (OcasionalIntervention $ocasionalIntervention) use ($beneficiary) {
                    $case = $beneficiary->cases()->create([
                        'name' => $ocasionalIntervention->reason,
                        'type' => CaseType::OCASIONAL,
                        'initiator' => CaseInitiator::NURSE,
                        'notes' => null,
                    ]);

                    $case->interventions()->createMany(
                        $ocasionalIntervention->services
                            ->map(fn (Service $service) => [
                                'date' => $ocasionalIntervention->date,
                                'service_id' => $service->id,
                            ])
                    );

                    $ocasionalIntervention->delete();
                });

            $beneficiary->update([
                'type' => Type::REGULAR,
            ]);

            $this->success();
        });

        $this->successNotificationTitle(__('beneficiary.action_convert.success'));
        $this->successRedirectUrl(fn () => BeneficiaryResource::getUrl('view', $this->getRecord()));
    }
}
