<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Actions;

use App\Filament\Resources\Beneficiaries\Resources\Interventions\InterventionResource;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Schemas\CaseForm;
use App\Models\Beneficiary;
use App\Models\Intervention;
use App\Models\Intervention\InterventionableCase;
use Filament\Actions\CreateAction;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CreateCaseAction extends CreateAction
{
    public static function getDefaultName(): ?string
    {
        return 'create_case';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('intervention.action.open_case'));

        $this->modalHeading(__('intervention.action.open_case'));

        $this->modal();

        $this->model(null);

        $this->icon(Heroicon::OutlinedFolderPlus);

        $this->groupedIcon(null);

        $this->createAnother(false);

        $this->using(function (array $data, Beneficiary $record): Intervention {
            $interventionable = InterventionableCase::create($data['interventionable']);

            $intervention = $interventionable->intervention()->create([
                'beneficiary_id' => $record?->id,
                'integrated' => $data['integrated'],
                'notes' => $data['notes'],
            ]);

            $intervention
                ->setVulnerability($data['vulnerability_id'])
                ->save();

            return $intervention;
        });

        $this->schema(fn (Schema $schema) => CaseForm::configure($schema));

        // TODO: fix
        // $this->disabled(fn (Beneficiary $record) => ! InterventionResource::hasValidVulnerabilities($record));
    }
}
