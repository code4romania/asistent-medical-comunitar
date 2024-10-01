<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Pages;

use App\Concerns\InteractsWithBeneficiary;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Forms\Components\Card;
use App\Filament\Forms\Components\Subsection;
use App\Filament\Forms\Components\Value;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns\HasSidebar;
use App\Filament\Resources\InterventionResource;
use App\Filament\Resources\InterventionResource\Actions\ToggleCaseStatusAction;
use App\Filament\Resources\InterventionResource\Concerns;
use App\Models\Intervention;
use Filament\Pages;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewIntervention extends ViewRecord implements WithSidebar
{
    use Concerns\HasRecordBreadcrumb;
    use HasSidebar;
    use InteractsWithBeneficiary;

    protected static string $resource = InterventionResource::class;

    public function mount(...$args): void
    {
        [$beneficiary, $intervention] = $args;

        parent::mount($intervention);

        $this->resolveBeneficiary($beneficiary);
    }

    public function getTitle(): string
    {
        return \sprintf(
            '%s: %s',
            $this->getRecord()->type,
            $this->getRecord()->name
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
                ->columnSpan([
                    'lg' => 2,
                ])
                ->schema([
                    Value::make('interventionable.name')
                        ->label(__('field.intervention_name')),

                    Value::make('interventionable.initiator')
                        ->label(__('field.initiator')),

                    Value::make('vulnerability_label')
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

            Subsection::make()
                ->icon('heroicon-o-clipboard-check')
                ->columnSpanFull()
                ->schema([
                    Value::make('interventionable.recommendations')
                        ->label(__('field.monitoring_recommendations')),
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

                    Value::make('vulnerability_label')
                        ->label(__('field.addressed_vulnerability')),

                    Value::make('integrated')
                        ->label(__('field.integrated'))
                        ->boolean(),

                    Value::make('interventionable.outside_working_hours')
                        ->label(__('field.outside_working_hours'))
                        ->boolean(),

                    Value::make('status')
                        ->label(__('field.status')),

                    Value::make('interventionable.date')
                        ->label(__('field.date')),
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

            Pages\Actions\EditAction::make()
                ->label(__('intervention.action.edit'))
                ->url(BeneficiaryResource::getUrl('interventions.edit', [
                    'beneficiary' => $this->getBeneficiary(),
                    'record' => $this->getRecord(),
                ]))
                ->color('secondary'),

            Pages\Actions\DeleteAction::make()
                ->label(__('intervention.action.delete'))
                ->successRedirectUrl(BeneficiaryResource::getUrl('interventions.index', [
                    'beneficiary' => $this->getBeneficiary(),
                ])),

            // Action::make('export')
            //     ->label(__('intervention.action.export'))
            //     ->icon('heroicon-s-download')
            //     ->color('secondary')
            //     ->disabled(),

            ToggleCaseStatusAction::make()
                ->visible(fn ($record) => $record->isCase() && ! $record->interventionable->is_imported)
                ->record($this->getRecord()),

        ];
    }
}
