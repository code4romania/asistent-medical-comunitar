<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Pages;

use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns\HasSidebar;
use App\Filament\Resources\InterventionResource;
use App\Filament\Resources\InterventionResource\Actions\ToggleCaseStatusAction;
use App\Filament\Resources\InterventionResource\Concerns;
use App\Forms\Components\Card;
use App\Forms\Components\Subsection;
use App\Forms\Components\Value;
use App\Models\Intervention;
use Filament\Pages\Actions\Action;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewIntervention extends ViewRecord implements WithSidebar
{
    use Concerns\HasRecordBreadcrumb;
    use HasSidebar;

    protected static string $resource = InterventionResource::class;

    public function getTitle(): string
    {
        return __(
            sprintf(
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

    public function beforeFill()
    {
        if ($this->getRecord()->parent_id !== null) {
            $this->redirect($this->getRecord()->parent->url);
        }
    }

    protected function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->header(__('intervention.summary'))
                    ->componentActions(fn ($record) => [
                        Action::make('edit')
                            ->label(__('intervention.action.edit'))
                            ->url(BeneficiaryResource::getUrl('interventions.edit', [$this->getBeneficiary(), $this->getRecord()]))
                            ->color('secondary'),
                    ])
                    ->columns(3)
                    ->schema(
                        fn (Intervention $record) => $record->isCase()
                            ? $this->getCaseFormSchema()
                            : $this->getIndividualServiceFormSchema()
                    ),
            ]);
    }

    protected function getCaseFormSchema(): array
    {
        return [
            Subsection::make()
                ->icon('heroicon-o-document-text')
                ->columns(2)
                ->columnSpan(2)
                ->schema([
                    Value::make('interventionable.name')
                        ->label(__('field.case_management_type')),

                    Value::make('interventionable.initiator')
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
        ];
    }

    protected function getIndividualServiceFormSchema(): array
    {
        return [
            Subsection::make()
                ->icon('heroicon-o-document-text')
                ->columns(2)
                ->columnSpan(2)
                ->schema([
                    Value::make('name')
                        ->label(__('field.service')),

                    Value::make('vulnerability.name')
                        ->label(__('field.addressed_vulnerability')),

                    Value::make('integrated')
                        ->label(__('field.integrated'))
                        ->boolean(),

                    Value::make('interventionable.outside_working_hours')
                        ->label(__('field.outside_working_hours'))
                        ->boolean(),

                    Value::make('status')
                        ->label(__('field.status')),
                ]),

            Subsection::make()
                ->icon('heroicon-o-annotation')
                ->schema([
                    Value::make('notes')
                        ->label(__('field.notes')),
                ]),
        ];
    }

    protected function getActions(): array
    {
        return [

            // Action::make('delete')
            //     ->label(__('intervention.action.delete'))
            //     ->color('danger')
            //     ->outlined()
            //     ->disabled(),

            // Action::make('export')
            //     ->label(__('intervention.action.export'))
            //     ->icon('heroicon-s-download')
            //     ->color('secondary')
            //     ->disabled(),

            ToggleCaseStatusAction::make()
                ->visible(fn ($record) => $record->isCase())
                ->record($this->getRecord()),

        ];
    }
}
