<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\ReportType;
use App\Filament\Resources\ReportResource\Pages;
use App\Models\Report;
use App\Tables\Columns\TextColumn;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getModelLabel(): string
    {
        return __('report.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('report.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns([
                'md' => 2,
                'lg' => 4,
            ])
            ->schema([
                Select::make('type')
                    ->label(__('report.column.type'))
                    ->placeholder(__('placeholder.select_one'))
                    ->options(ReportType::options())
                    ->enum(ReportType::class)
                    ->required()
                    ->searchable(),

                Fieldset::make('indicators')
                    ->label(__('report.column.indicators'))
                    ->columnSpan([
                        'lg' => 3,
                    ])
                    ->schema([
                        Select::make('beneficiaries')
                            ->label(__('report.column.beneficiaries'))
                            ->placeholder(__('placeholder.select_many'))
                            ->options([
                                'Total beneficiari',
                                'Beneficiari înregistrați',
                                'Beneficiari catagrafiați',
                                'Beneficiari activi',
                                'Beneficiari inactivi',
                                'Beneficiari scoși din evidență',
                                'Beneficiari scoși din evidență',
                            ])
                            ->multiple()
                            ->searchable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label(__('report.column.created_at'))
                    ->formatStateUsing(fn ($record) => $record->created_at->toFormattedDateTime())
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label(__('report.column.type'))
                    ->toggleable(),

                TextColumn::make('name')
                    ->label(__('report.column.name'))
                    ->toggleable()
                    ->searchable(),

                TextColumn::make('indicators')
                    ->label(__('report.column.indicators'))
                    ->toggleable()
                    ->searchable(),

                TextColumn::make('segmentation')
                    ->label(__('report.column.segmentation'))
                    ->toggleable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\GenerateReport::route('/'),
            'saved' => Pages\ListReports::route('/saved'),

            // 'create' => Pages\CreateReport::route('/create'),
            // 'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
