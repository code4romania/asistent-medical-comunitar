<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Actions;

use App\Filament\Resources\Beneficiaries\Resources\Interventions\InterventionResource;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Schemas\CaseForm;
use App\Models\Beneficiary;
use App\Models\Intervention;
use App\Models\Intervention\InterventionableCase;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\Page;
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

        $this->using(function (array $data, Page $livewire): Intervention {
            /** @var Beneficiary|Intervention */
            $record = $livewire->getRecord();

            /** @var Beneficiary */
            $beneficiary = $record instanceof Beneficiary ? $record : $record->beneficiary;

            $interventionable = InterventionableCase::create($data['interventionable']);

            $intervention = $interventionable->intervention()->create([
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

        $this->schema(fn (Schema $schema) => CaseForm::configure($schema));

        $this->disabled(fn (Page $livewire) => ! InterventionResource::hasValidVulnerabilities($livewire->getRecord()));
    }

    /**
     * Workaround to force modal opening on beneficiary pages.
     */
    public function getUrl(): ?string
    {
        return null;
    }
}
