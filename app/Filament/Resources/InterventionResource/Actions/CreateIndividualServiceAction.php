<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Actions;

use App\Filament\Resources\InterventionResource;
use App\Models\Intervention\InterventionableIndividualService;
use Filament\Pages\Actions\CreateAction;

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

        $this->disableCreateAnother();

        $this->using(function (array $data, $livewire) {
            $interventionable = InterventionableIndividualService::create($data['interventionable']);

            return $interventionable->intervention()->create([
                'beneficiary_id' => $livewire->getBeneficiary()?->id,
                'vulnerability_id' => $data['vulnerability'],
                'integrated' => $data['integrated'],
                'notes' => $data['notes'],
            ]);
        });

        $this->form(InterventionResource::getIndividualServiceFormSchema());

        $this->disabled(fn ($livewire) => ! InterventionResource::hasValidVulnerabilities($livewire));
    }
}
