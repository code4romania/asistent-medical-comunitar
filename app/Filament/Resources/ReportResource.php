<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\Report\Indicator;
use App\Enums\Report\Segment;
use App\Enums\Report\Type;
use App\Filament\Forms\Components\ReportCard;
use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Tables\Columns\TextColumn;
use App\Models\Report;
use App\Rules\MultipleIn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return __('report.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('report.label.plural');
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
                    ->enum(Type::options())
                    ->toggleable(),

                TextColumn::make('title')
                    ->label(__('report.column.title'))
                    ->wrap()
                    ->toggleable()
                    ->searchable(),

                TextColumn::make('indicators')
                    ->label(__('report.column.indicators'))
                    ->formatStateUsing(fn (Report $record) => Str::limit($record->indicators_list, 100, '...'))
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('segments.age')
                    ->label(__('report.column.age'))
                    ->formatStateUsing(fn ($state) => static::segmentsList('age', $state))
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('segments.gender')
                    ->label(__('report.column.gender'))
                    ->formatStateUsing(fn ($state) => static::segmentsList('gender', $state))
                    ->wrap()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton(),
            ])
            ->defaultSort('id', 'desc');
    }

    protected static function segmentsList(string $group, string $segments): string
    {
        return collect(explode(', ', $segments))
            ->filter()
            ->map(fn (string $segment) => __(sprintf('report.segment.value.%s.%s', $group, $segment)))
            ->join(', ');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ComingSoon::route('/'),
            // 'index' => Pages\GenerateReport::route('/generate'),
            // 'saved' => Pages\ListReports::route('/'),
            // 'view' => Pages\ViewReport::route('/{record}'),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Select::make('type')
                    ->label(__('report.column.type'))
                    ->placeholder(__('placeholder.select_one'))
                    ->disablePlaceholderSelection()
                    ->default(Type::NURSE_ACTIVITY)
                    ->options(Type::options())
                    ->enum(Type::class)
                    ->required()
                    ->reactive(),

                DatePicker::make('date_from')
                    ->label(__('app.filter.date_from'))
                    ->placeholder(
                        fn (): string => today()
                            ->subYear()
                            ->toFormattedDate()
                    )
                    ->maxDate(today())
                    ->required(),

                DatePicker::make('date_until')
                    ->label(__('app.filter.date_until'))
                    ->placeholder(
                        fn (): string => today()
                            ->toFormattedDate()
                    )
                    ->afterOrEqual('date_from')
                    ->maxDate(today()),

                Grid::make(4)
                    ->schema(static::getNurseActivitySchema())
                    ->visible(fn (callable $get) => Type::NURSE_ACTIVITY->is($get('type')))
                    ->columnSpanFull(),

                Select::make('segments.age')
                    ->label(__('report.segment.label.age'))
                    ->placeholder(__('placeholder.select_many'))
                    ->options(Segment\Age::options())
                    ->rule(new MultipleIn(Segment\Age::values()))
                    ->multiple()
                    ->searchable(),

                Select::make('segments.gender')
                    ->label(__('report.segment.label.gender'))
                    ->placeholder(__('placeholder.select_many'))
                    ->options(Segment\Gender::options())
                    ->rule(new MultipleIn(Segment\Gender::values()))
                    ->multiple(),
            ]);
    }

    public static function report(Form $form): Form
    {
        return $form
            ->schema(ReportCard::make());
    }

    protected static function getNurseActivitySchema(): array
    {
        return [
            Fieldset::make(__('report.column.indicators'))
                ->columnSpanFull()
                ->columns(3)
                ->schema([
                    Select::make('indicators.beneficiaries')
                        ->label(__('report.indicator.label.beneficiaries'))
                        ->placeholder(__('placeholder.select_many'))
                        ->options(Indicator\Beneficiaries::options())
                        ->rule(new MultipleIn(Indicator\Beneficiaries::values()))
                        ->multiple()
                        ->searchable(),

                    Select::make('indicators.general_record')
                        ->label(__('report.indicator.label.general_record'))
                        ->placeholder(__('placeholder.select_many'))
                        ->options(Indicator\GeneralRecord::options())
                        ->rule(new MultipleIn(Indicator\GeneralRecord::values()))
                        ->multiple()
                        ->searchable(),
                ]),
        ];
    }
}
