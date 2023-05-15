<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Pages;

use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns\HasSidebar;
use App\Filament\Resources\InterventionResource;
use App\Filament\Resources\InterventionResource\Concerns;
use App\Forms\Components\Card;
use App\Models\Intervention\CaseManagement;
use Filament\Pages\Actions\Action;
use Filament\Resources\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditIntervention extends EditRecord implements WithSidebar
{
    use Concerns\HasRecordBreadcrumb;
    use Concerns\InteractsWithCaseRecord;
    use HasSidebar;

    protected static string $resource = InterventionResource::class;

    public ?CaseManagement $intervention = null;

    public function getTitle(): string
    {
        return __('case.title', [
            'name' => $this->intervention?->name,
        ]);
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    protected function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->header(__('case.summary'))
                    ->columns(3)
                    ->schema(
                        InterventionResource::getCaseFormSchema(columns: 3)
                    ),

            ]);
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->makeForm()
                ->context('edit')
                ->model($this->intervention)
                ->schema($this->getFormSchema())
                ->statePath('data')
                ->inlineLabel(config('filament.layout.forms.have_inline_labels')),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $this->intervention->attributesToArray();
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $this->intervention->update($data);

        return $this->intervention;
    }

    protected function getActions(): array
    {
        return [];
    }

    protected function getCancelFormAction(): Action
    {
        return Action::make('cancel')
            ->label(__('filament::resources/pages/edit-record.form.actions.cancel.label'))
            ->url($this->previousUrl ?? $this->getRedirectUrl())
            ->color('secondary');
    }

    protected function getRedirectUrl(): ?string
    {
        return BeneficiaryResource::getUrl('interventions.view', [$this->record, $this->intervention]);
    }
}
