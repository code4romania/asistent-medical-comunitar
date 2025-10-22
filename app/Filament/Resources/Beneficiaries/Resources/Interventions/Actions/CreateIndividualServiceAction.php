<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Actions;

use App\Filament\Resources\Beneficiaries\Resources\Interventions\InterventionResource;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Schemas\IndividualServiceForm;
use App\Models\Beneficiary;
use App\Models\Intervention;
use App\Models\Intervention\InterventionableIndividualService;
use Filament\Actions\CreateAction;
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

        $this->using(function (array $data, Beneficiary $record): Intervention {
            $interventionable = InterventionableIndividualService::create($data['interventionable']);

            $intervention = $interventionable->intervention()->make([
                'beneficiary_id' => $record?->id,
                'integrated' => $data['integrated'],
                'notes' => $data['notes'],
            ]);

            $intervention
                ->setVulnerability($data['vulnerability_id'])
                ->save();

            return $intervention;
        });

        $this->schema(fn (Schema $schema) => IndividualServiceForm::configure($schema));

        // TODO: fix
        // $this->disabled(fn (Beneficiary $record) => ! InterventionResource::hasValidVulnerabilities($record));
    }
}
