<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use App\Enums\Beneficiary\Type;
use App\Enums\Intervention\CaseInitiator;
use App\Enums\Intervention\Status;
use App\Filament\Resources\BeneficiaryResource;
use App\Models\Beneficiary;
use App\Models\Intervention\InterventionableCase;
use App\Models\Intervention\InterventionableIndividualService;
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

        $this->color('gray');

        $this->action(function () {
            /** @var Beneficiary */
            $beneficiary = $this->getRecord();

            $beneficiary->update([
                'type' => Type::REGULAR,
            ]);

            $beneficiary->ocasionalInterventions()
                ->with('services')
                ->get()
                ->map(function (OcasionalIntervention $ocasionalIntervention) use ($beneficiary) {
                    $interventionable = InterventionableCase::create([
                        'name' => $ocasionalIntervention->reason,
                        'initiator' => CaseInitiator::NURSE,
                        'is_imported' => true,
                    ]);

                    $case = $interventionable->intervention()->create([
                        'closed_at' => now(),
                        'beneficiary_id' => $beneficiary->id,
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
        $this->successRedirectUrl(fn () => BeneficiaryResource::getUrl('view', $this->getRecord()));
    }
}
