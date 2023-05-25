<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\Gender;
use App\Enums\Report\Indicator;
use App\Enums\Report\Type;
use App\Filament\Resources\ReportResource\Pages;
use App\Models\Report;
use App\Models\Vulnerability\Vulnerability;
use App\Models\Vulnerability\VulnerabilityCategory;
use App\Rules\MultipleIn;
use App\Tables\Columns\TextColumn;
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

    protected static ?string $navigationIcon = 'heroicon-o-collection';

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

                TextColumn::make('name')
                    ->label(__('report.column.name'))
                    ->toggleable()
                    ->searchable(),

                TextColumn::make('indicators')
                    ->label(__('report.column.indicators'))
                    ->formatStateUsing(fn (Report $record) => Str::limit($record->indicators_list, 100, '...'))
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('segments')
                    ->label(__('report.column.segments'))
                    ->formatStateUsing(fn (Report $record) => Str::limit($record->segments_list, 100, '...'))
                    ->wrap()
                    ->toggleable(),
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
            'index' => Pages\GenerateReport::route('/generate'),
            'saved' => Pages\ListReports::route('/'),

            // 'create' => Pages\CreateReport::route('/create'),
            // 'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }

    public static function form(Form $form): Form
    {
        $vulnerabilities = Vulnerability::allAsOptions();
        $categories = VulnerabilityCategory::cachedList();

        return $form
            ->columns(4)
            ->schema([
                Select::make('type')
                    ->label(__('report.column.type'))
                    ->placeholder(__('placeholder.select_one'))
                    ->options(Type::options())
                    ->enum(Type::class)
                    ->required()
                    ->searchable()
                    ->reactive()
                    ->columnSpan(2),

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
                    ->visible(fn (callable $get) => Type::NURSE_ACTIVITY->is($get('type'))),

                Select::make('segments.age')
                    ->label($categories->get('AGE'))
                    ->placeholder(__('placeholder.no_segmentation_age'))
                    ->options($vulnerabilities->get('AGE'))
                    // ->in($vulnerabilities->get('AGE')->keys())
                    ->multiple()
                    ->searchable(),

                Select::make('segments.gender')
                    ->label(__('field.gender'))
                    ->placeholder(__('placeholder.no_segmentation_gender'))
                    ->options(Gender::options())
                    ->rule(new MultipleIn(Gender::values()))
                    ->multiple(),

            ]);
    }

    protected static function getNurseActivitySchema(): array
    {
        return [
            Fieldset::make(__('report.column.indicators'))
                ->columnSpanFull()
                ->schema([
                    Select::make('indicators.beneficiaries')
                        ->label(__('report.indicator.beneficiaries.name'))
                        ->placeholder(__('placeholder.select_many'))
                        ->options(Indicator\Beneficiaries::options())
                        ->rule(new MultipleIn(Indicator\Beneficiaries::values()))
                        ->multiple()
                        ->searchable(),
                ]),
        ];
    }
}
