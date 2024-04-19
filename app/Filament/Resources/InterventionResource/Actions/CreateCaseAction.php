<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Actions;

use App\Filament\Resources\InterventionResource;
use App\Models\Intervention;
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

        $this->groupedIcon(null);

        $this->disableCreateAnother();

        $this->using(fn (array $data, $livewire) => static::create($data, $livewire));

        $this->form(InterventionResource::getCaseFormSchema());

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
