<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Pages;

use App\Concerns\InteractsWithBeneficiary;
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

class EditIntervention extends EditRecord implements WithSidebar
{
    use Concerns\HasRecordBreadcrumb;
    use HasSidebar;
    use InteractsWithBeneficiary;

    protected static string $resource = InterventionResource::class;

    public function mount(...$args): void
    {
        [$beneficiary, $intervention] = $args;

        $this->resolveBeneficiary($beneficiary);

        $this->record = app(CaseManagement::class)
            ->resolveRouteBindingQuery($this->getBeneficiary()->cases(), $intervention)
            ->first();

        $this->authorizeAccess();

        $this->fillForm();
    }

    public function getTitle(): string
    {
        return __('case.title', [
            'name' => $this->getRecordTitle(),
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
        return BeneficiaryResource::getUrl('interventions.view', [
            'record' => $this->getBeneficiary(),
            'intervention' => $this->getRecord(),
        ]);
    }
}
