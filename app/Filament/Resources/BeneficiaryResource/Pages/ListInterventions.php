<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Filament\Resources\BeneficiaryResource\RelationManagers\InterventionsRelationManager;
use App\Forms\Components\Radio;
use App\Models\Intervention\Intervention;
use App\Models\Vulnerability\Vulnerability;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ListInterventions extends ViewRecord implements WithSidebar
{
    use Concerns\FiltersRelationManagers;
    use Concerns\HasActions;
    use Concerns\HasRecordBreadcrumb;
    use Concerns\HasSidebar;

    protected static string $resource = BeneficiaryResource::class;

    protected static string $view = 'filament.pages.relation-managers';

    public function getTitle(): string
    {
        return __('intervention.label.plural');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    protected function getActions(): array
    {
        $vulnerabilities = Vulnerability::cachedList()
            ->pluck('name', 'id');

        return [
            Actions\CreateAction::make('add_service')
                ->label(__('intervention.action.add_service'))
                ->modalHeading(__('intervention.action.add_service'))
                ->icon('heroicon-o-plus-circle')
                ->model(Intervention::class)
                ->disableCreateAnother()
                ->using(function (array $data) {
                    $data['beneficiary_id'] = data_get($this->getRecord(), 'id');

                    return Intervention::create($data);
                })
                ->form([
                    Grid::make(2)
                        ->schema([
                            Select::make('service')
                                ->relationship('service', 'name')
                                ->label(__('field.service'))
                                ->placeholder(__('placeholder.select_one'))
                                ->searchable()
                                ->preload(),

                            Select::make('vulnerability')
                                ->relationship('vulnerability', 'name')
                                ->label(__('field.targeted_vulnerability'))
                                ->placeholder(__('placeholder.select_one'))
                                ->options($vulnerabilities)
                                ->in($vulnerabilities->keys())
                                ->searchable(),

                            Select::make('case')
                                ->label(__('field.associated_case'))
                                ->disabled(),

                            Select::make('status')
                                ->label(__('field.service_status'))
                                ->disabled(),

                            DatePicker::make('date')
                                ->label(__('field.date')),

                            Radio::make('integrated')
                                ->label(__('field.integrated'))
                                ->helperText('ceva help text aici TBD')
                                ->inlineOptions()
                                ->boolean()
                                ->default(0),

                            Textarea::make('notes')
                                ->autosize(false)
                                ->rows(4)
                                ->extraInputAttributes([
                                    'class' => 'resize-none',
                                ])
                                ->columnSpanFull(),

                            Checkbox::make('outside_working_hours')
                                ->label(__('field.outside_working_hours')),
                        ]),
                ]),

            Actions\CreateAction::make('open_case')
                ->label(__('intervention.action.open_case'))
                ->icon('heroicon-o-folder-add'),
            // ->modalHeading(__('beneficiary.action_convert_confirm.title'))
            // ->modalSubheading(__('beneficiary.action_convert_confirm.text'))
            // ->modalButton(__('beneficiary.action_convert_confirm.action'))
            // ->modalWidth('md')
            // ->centerModal(false)

        ];
    }

    protected function getAllowedRelationManager(): ?string
    {
        return InterventionsRelationManager::class;
    }
}
