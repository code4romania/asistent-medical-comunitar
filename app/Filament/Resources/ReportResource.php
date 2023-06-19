<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\Report\Indicator;
use App\Enums\Report\Segment;
use App\Enums\Report\Type;
use App\Filament\Forms\Components\Card;
use App\Filament\Forms\Components\Report as ReportOutput;
use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Tables\Columns\TextColumn;
use App\Models\Report;
use App\Models\Vulnerability\Vulnerability;
use App\Models\Vulnerability\VulnerabilityCategory;
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
            'view' => Pages\ViewReport::route('/{record}'),
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
                    ->disablePlaceholderSelection()
                    ->default(Type::NURSE_ACTIVITY)
                    ->options(Type::options())
                    ->enum(Type::class)
                    ->required()
                    ->reactive()
                    ->columnSpan([
                        'lg' => 2,
                    ]),

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
                    ->label(__('report.column.age'))
                    ->placeholder(__('placeholder.select_many'))
                    ->options(Segment\Age::options())
                    ->rule(new MultipleIn(Segment\Age::values()))
                    ->multiple()
                    ->searchable(),

                Select::make('segments.gender')
                    ->label(__('report.column.gender'))
                    ->placeholder(__('placeholder.select_many'))
                    ->options(Segment\Gender::options())
                    ->rule(new MultipleIn(Segment\Gender::values()))
                    ->multiple(),
            ]);
    }

    public static function report(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->header(fn (Report $record) => $record->title)
                    ->componentActions([
                        Action::make('export')
                            ->label(__('report.action.export'))
                            ->icon('heroicon-o-download')
                            ->color('secondary')
                            ->disabled(),

                        Action::make('save')
                            ->label(__('report.action.save'))
                            ->icon('heroicon-o-bookmark-alt')
                            ->disabled(),
                    ])
                    ->schema([
                        ReportOutput::make(),
                    ]),
            ]);
    }

    protected static function getNurseActivitySchema(): array
    {
        return [
            Fieldset::make(__('report.column.indicators'))
                ->columnSpanFull()
                ->schema([
                    Select::make('indicators.beneficiaries')
                        ->label(__('beneficiary.label.plural'))
                        ->placeholder(__('placeholder.select_many'))
                        ->options(Indicator\Beneficiaries::options())
                        ->rule(new MultipleIn(Indicator\Beneficiaries::values()))
                        ->multiple()
                        ->searchable(),
                ]),
        ];
    }
}
