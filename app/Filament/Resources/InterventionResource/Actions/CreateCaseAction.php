<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Actions;

use App\Filament\Resources\InterventionResource;
use App\Models\Intervention\InterventionableCase;
use Filament\Pages\Actions\CreateAction;

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

        $this->icon('heroicon-o-folder-add');

        $this->disableCreateAnother();

        $this->using(function (array $data, $livewire) {
            $interventionable = InterventionableCase::create($data['interventionable']);

            return $interventionable->intervention()->create([
                'beneficiary_id' => $livewire->getBeneficiary()?->id,
                'vulnerability_id' => $data['vulnerability'],
                'integrated' => $data['integrated'],
                'notes' => $data['notes'],
            ]);
        });

        $this->form(InterventionResource::getCaseFormSchema());

        $this->disabled(fn ($livewire) => ! InterventionResource::hasValidVulnerabilities($livewire));
    }
}
