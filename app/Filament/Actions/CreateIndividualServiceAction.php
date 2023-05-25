<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use App\Enums\Intervention\Status;
use App\Forms\Components\Radio;
use App\Models\Intervention\IndividualService;
use App\Models\Vulnerability\Vulnerability;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Pages\Actions\CreateAction;

class CreateIndividualServiceAction extends CreateAction
{
    public static function getDefaultName(): ?string
    {
        return 'create_individual_service';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('intervention.action.add_service'));

        $this->modalHeading(__('intervention.action.add_service'));

        $this->icon('heroicon-o-plus-circle');

        $this->disableCreateAnother();

        $this->model(IndividualService::class);

        $this->using(function (array $data) {
            $data['beneficiary_id'] = $this->getRecord()?->id;

            return IndividualService::create($data);
        });

        $this->form(function () {
            $vulnerabilities = Vulnerability::cachedList()
                ->pluck('name', 'id');

            return [
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
                            ->label(__('field.addressed_vulnerability'))
                            ->placeholder(__('placeholder.select_one'))
                            ->options($vulnerabilities)
                            ->in($vulnerabilities->keys())
                            ->searchable(),

                        Select::make('status')
                            ->label(__('field.status'))
                            ->options(Status::options())
                            ->enum(Status::class)
                            ->default(Status::PLANNED),

                        DatePicker::make('date')
                            ->label(__('field.date')),

                        Radio::make('integrated')
                            ->label(__('field.integrated'))
                            ->inlineOptions()
                            ->boolean()
                            ->default(0),

                        Textarea::make('notes')
                            ->label(__('field.notes'))
                            ->autosize(false)
                            ->rows(4)
                            ->extraInputAttributes([
                                'class' => 'resize-none',
                            ])
                            ->columnSpanFull(),

                        Checkbox::make('outside_working_hours')
                            ->label(__('field.outside_working_hours')),
                    ]),
            ];
        });
    }
}
