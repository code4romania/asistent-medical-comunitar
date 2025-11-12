<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Pages;

use App\Filament\Resources\Beneficiaries\Concerns\UsesParentRecordSubNavigation;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Concerns\HasBreadcrumbs;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\InterventionResource;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Schemas\CaseForm;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Schemas\IndividualServiceForm;
use App\Models\Intervention;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EditIntervention extends EditRecord
{
    use HasBreadcrumbs;
    use UsesParentRecordSubNavigation;

    protected static string $resource = InterventionResource::class;

    public function getTitle(): string
    {
        return $this->getRecordTitle();
    }

    public function form(Schema $schema): Schema
    {
        /** @var Intervention */
        $intervention = $this->getRecord();

        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->heading(__('intervention.summary'))
                    ->components(
                        fn (Schema $schema) => $intervention->isCase()
                            ? CaseForm::configure($schema)
                            : IndividualServiceForm::configure($schema)
                    ),
            ]);
    }

    public function mutateFormDataBeforeFill(array $data): array
    {
        $data['interventionable'] = $this->getRecord()->interventionable->attributesToArray();

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->interventionable->update(Arr::pull($data, 'interventionable'));

        $record->setVulnerability($data['vulnerability_id']);

        unset($data['vulnerability_id']);
        unset($data['vulnerability_label']);

        $record->update($data);

        return $record;
    }

    public function getRelationManagers(): array
    {
        return [
            //
        ];
    }
}
