<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Actions;

use App\Filament\Resources\InterventionResource;
use App\Models\Intervention;
use App\Models\Intervention\InterventionableIndividualService;
use Filament\Actions\CreateAction;

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

        $this->icon('heroicon-o-plus-circle');

        $this->groupedIcon(null);

        $this->createAnother(false);

        $this->using(fn (array $data, $livewire) => static::create($data, $livewire));

        $this->form(InterventionResource::getIndividualServiceFormSchema());

        $this->disabled(fn ($livewire) => ! InterventionResource::hasValidVulnerabilities($livewire));
    }

    public static function create(array $data, $livewire): Intervention
    {
        $interventionable = InterventionableIndividualService::create($data['interventionable']);

        $intervention = $interventionable->intervention()->make([
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
