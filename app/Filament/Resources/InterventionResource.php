<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\Intervention\CaseInitiator;
use App\Filament\Resources\InterventionResource\Pages;
use App\Forms\Components\Radio;
use App\Forms\Components\Subsection;
use App\Models\Intervention\IndividualService;
use App\Models\Vulnerability\Vulnerability;
use App\Tables\Columns\InterventionsColumn;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\Layout;
use Filament\Tables\Columns\TextColumn;

class InterventionResource extends Resource
{
    protected static ?string $model = IndividualService::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Layout\Grid::make(3)
                    ->schema([
                        TextColumn::make('name')
                            ->label(__('field.vulnerability'))
                            ->alignment('left')
                            ->searchable()
                            ->extraAttributes(fn (Vulnerability $record) => [
                                'class' => $record->id === 'NONE' ? 'italic' : null,
                            ])
                            ->sortable(),

                        TextColumn::make('interventions_count')
                            ->counts('interventions')
                            ->alignment('left')
                            ->label(__('field.interventions'))
                            ->sortable(),

                        TextColumn::make('services_count')
                            ->label(__('field.status'))
                            ->alignment('left')
                            ->sortable(),
                    ]),

                Layout\Split::make([
                    InterventionsColumn::make('interventions'),
                ])->collapsible(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageInterventions::route('/'),
        ];
    }

    public static function getIndividualServiceFormSchema(): array
    {
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
    }

    public static function getCaseFormSchema(): array
    {
        $vulnerabilities = Vulnerability::cachedList()
            ->pluck('name', 'id');

        return [
            Subsection::make()
                ->icon('heroicon-o-document-text')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label(__('field.intervention_name'))
                        ->columnSpanFull(),

                    Select::make('initiator')
                        ->label(__('field.initiator'))
                        ->placeholder(__('placeholder.choose'))
                        ->options(CaseInitiator::options())
                        ->enum(CaseInitiator::class)
                        ->default(CaseInitiator::NURSE)
                        ->required(),

                    Select::make('vulnerability')
                        ->relationship('vulnerability', 'name')
                        ->label(__('field.targeted_vulnerability'))
                        ->placeholder(__('placeholder.select_one'))
                        ->options($vulnerabilities)
                        ->in($vulnerabilities->keys())
                        ->searchable()
                        ->required(),

                    Radio::make('integrated')
                        ->label(__('field.integrated'))
                        ->helperText('ceva help text aici TBD')
                        ->inlineOptions()
                        ->boolean()
                        ->default(0),
                ]),

            Subsection::make()
                ->icon('heroicon-o-annotation')
                ->schema([
                    Textarea::make('notes')
                        ->label(__('field.notes'))
                        ->autosize(false)
                        ->rows(4)
                        ->extraInputAttributes([
                            'class' => 'resize-none',
                        ]),
                ]),
        ];
    }
}
