<?php

declare(strict_types=1);

namespace App\Filament\Resources\Interventions\Actions;

use App\Filament\Resources\Interventions\InterventionResource;
use App\Models\Intervention;
use App\Models\Intervention\InterventionableCase;
use Filament\Actions\CreateAction;

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

        $this->icon('heroicon-o-folder-plus');

        $this->groupedIcon(null);

        $this->createAnother(false);

        $this->using(fn (array $data, $livewire) => static::create($data, $livewire));

        $this->schema(InterventionResource::getCaseFormSchema());

        $this->disabled(fn ($livewire) => ! InterventionResource::hasValidVulnerabilities($livewire));
    }

    public static function create(array $data, $livewire): Intervention
    {
        $interventionable = InterventionableCase::create($data['interventionable']);

        $intervention = $interventionable->intervention()->create([
            'beneficiary_id' => $livewire->getBeneficiary()?->id,
            'integrated' => $data['integrated'],
            'notes' => $data['notes'],
        ]);

        $intervention
            ->setVulnerability($data['vulnerability_id'])
            ->save();

        return $intervention;
    }
}
