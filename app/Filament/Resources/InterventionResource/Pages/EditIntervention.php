<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Pages;

use App\Concerns\InteractsWithBeneficiary;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns\HasSidebar;
use App\Filament\Resources\InterventionResource;
use App\Filament\Resources\InterventionResource\Concerns;
use App\Models\Intervention;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EditIntervention extends EditRecord implements WithSidebar
{
    use Concerns\HasRecordBreadcrumb;
    use HasSidebar;
    use InteractsWithBeneficiary;

    protected static string $resource = InterventionResource::class;

    public function mount(int | string ...$args): void
    {
        [$beneficiary, $intervention] = $args;

        parent::mount($intervention);

        $this->resolveBeneficiary($beneficiary);
    }

    public function getTitle(): string
    {
        return __(
            \sprintf(
                'intervention.title.%s',
                $this->getRecord()->interventionable_type
            ),
            [
                'name' => $this->getRecord()->name,
            ]
        );
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->heading(__('intervention.summary'))
                    ->columns(3)
                    ->schema(
                        fn (Intervention $record) => $record->isCase()
                            ? InterventionResource::getCaseFormSchema(columns: 3)
                            : InterventionResource::getIndividualServiceFormSchema()
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

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getCancelFormAction(): Action
    {
        return Action::make('cancel')
            ->label(__('filament::resources/pages/edit-record.form.actions.cancel.label'))
            ->url($this->previousUrl ?? $this->getRedirectUrl())
            ->color('gray');
    }

    protected function getRedirectUrl(): ?string
    {
        return BeneficiaryResource::getUrl('interventions.view', [
            'beneficiary' => $this->getBeneficiary(),
            'record' => $this->getRecord(),
        ]);
    }
}
