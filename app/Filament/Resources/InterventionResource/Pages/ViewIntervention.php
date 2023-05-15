<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Pages;

use App\Contracts\Pages\WithSidebar;
use App\Filament\Actions\ToggleCaseManagementStatusAction;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns\HasSidebar;
use App\Filament\Resources\InterventionResource;
use App\Filament\Resources\InterventionResource\Concerns;
use App\Forms\Components\Card;
use App\Forms\Components\Subsection;
use App\Forms\Components\Value;
use App\Models\Intervention\CaseManagement;
use Filament\Pages\Actions\Action;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewIntervention extends ViewRecord implements WithSidebar
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
                    ->componentActions(fn ($record) => [
                        Action::make('edit')
                            ->label(__('intervention.action.edit'))
                            ->url(BeneficiaryResource::getUrl('interventions.edit', [$this->record, $this->intervention]))
                            ->color('secondary'),
                    ])
                    ->columns(3)
                    ->model($this->intervention)

                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-document-text')
                            ->columns(2)
                            ->columnSpan(2)
                            ->schema([
                                Value::make('name')
                                    ->label(__('field.case_management_type')),

                                Value::make('initiator')
                                    ->label(__('field.initiator')),

                                Value::make('vulnerability.name')
                                    ->label(__('field.addressed_vulnerability')),

                                Value::make('integrated')
                                    ->label(__('field.integrated'))
                                    ->boolean(),
                            ]),

                        Subsection::make()
                            ->icon('heroicon-o-annotation')
                            ->schema([
                                Value::make('notes')
                                    ->label(__('field.notes')),
                            ]),
                    ]),

            ]);
    }

    protected function getActions(): array
    {
        return [
            // Action::make('delete')
            //     ->label(__('intervention.action.delete'))
            //     ->color('danger')
            //     ->outlined()
            //     ->disabled(),

            Action::make('export')
                ->label(__('intervention.action.export'))
                ->icon('heroicon-s-download')
                ->color('secondary')
                ->disabled(),

            ToggleCaseManagementStatusAction::make()
                ->record($this->intervention),

        ];
    }
}
