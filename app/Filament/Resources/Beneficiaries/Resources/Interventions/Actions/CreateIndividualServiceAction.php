<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Actions;

use App\Filament\Resources\Beneficiaries\Resources\Interventions\InterventionResource;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Schemas\IndividualServiceForm;
use App\Models\Beneficiary;
use App\Models\Intervention;
use App\Models\Intervention\InterventionableIndividualService;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CreateIndividualServiceAction extends CreateAction
{
    public static function getDefaultName(): ?string
    {
        return 'create_individual_service';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('intervention.action.add_service'));

        $this->modalHeading(__('intervention.action.add_service'));

        $this->icon(Heroicon::OutlinedPlusCircle);

        $this->groupedIcon(null);

        $this->createAnother(false);

        $this->using(function (array $data, Page $livewire): Intervention {
            /** @var Beneficiary|Intervention */
            $record = $livewire->getRecord();

            /** @var Beneficiary */
            $beneficiary = $record instanceof Beneficiary ? $record : $record->beneficiary;

            $interventionable = InterventionableIndividualService::create($data['interventionable']);

            $intervention = $interventionable->intervention()->make([
                'beneficiary_id' => $beneficiary->id,
                'integrated' => $data['integrated'],
                'notes' => $data['notes'],
            ]);

            $intervention
                ->setVulnerability($data['vulnerability_id'])
                ->save();

            return $intervention;
        });

        $this->successRedirectUrl(
            fn (Intervention $record): string => InterventionResource::getUrl('view', [
                'beneficiary' => $record->beneficiary_id,
                'record' => $record,
            ])
        );

        $this->schema(fn (Schema $schema) => IndividualServiceForm::configure($schema));

        $this->disabled(fn (Page $livewire) => ! InterventionResource::hasValidVulnerabilities($livewire->getRecord()));
    }
}
