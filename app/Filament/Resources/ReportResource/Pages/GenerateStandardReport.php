<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Pages;

use App\Enums\Report\Standard\Category;
use App\Enums\Report\Type;
use App\Filament\Forms\Components\Card;
use App\Filament\Resources\ReportResource;
use App\Filament\Resources\ReportResource\Widgets\ReportTableWidget;
use App\Jobs\GenerateStandardReportJob;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class GenerateStandardReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;

    protected static bool $canCreateAnother = false;

    protected function afterCreate(): void
    {
        $data = $this->form->getState();

        $job = GenerateReport\Standard\GenerateStatisticJob::class;

        if (auth()->user()->isNurse()) {
            $job = match ($this->report->type) {
                Type::LIST => GenerateReport\Standard\GenerateListJob::class,
                Type::STATISTIC => GenerateReport\Standard\GenerateStatisticJob::class,
            };
        }
        $job::dispatch($this->record, $data);
    }

    protected function getFormSchema(): array
    {
        return [
            Card::make()
                ->columns(3)
                ->footerActions([
                    Action::make('cancel')
                        ->label(__('report.action.cancel'))
                        ->url($this->previousUrl ?? static::getResource()::getUrl())
                        ->color('secondary'),

                    Action::make('create')
                        ->label(__('report.action.generate'))
                        ->submit('create')
                        ->keyBindings(['mod+s'])
                        ->color('warning'),
                ])
                ->schema([
                    Grid::make()
                        ->columns(3)
                        ->schema([
                            Select::make('type')
                                ->label(__('report.column.type'))
                                ->placeholder(__('placeholder.select_one'))
                                ->visible(fn () => auth()->user()->isNurse())
                                ->options(Type::options())
                                ->enum(Type::class)
                                ->reactive()
                                ->required(),

                            Select::make('nurses')
                                ->label(__('report.column.nurses'))
                                ->placeholder(__('placeholder.select_many'))
                                ->visible(fn () => ! auth()->user()->isNurse())
                                ->allowHtml()
                                ->multiple()
                                ->options(
                                    fn () => User::query()
                                        ->onlyNurses()
                                        ->activatesInCounty(auth()->user()->county_id)
                                        ->withActivityAreas()
                                        ->get()
                                        ->mapWithKeys(fn (User $nurse) => [
                                            $nurse->getKey() => view('components.forms.option-label', [
                                                'name' => $nurse->full_name,
                                                'suffix' => $nurse->activityCities
                                                    ->pluck('name')
                                                    ->join(', '),
                                            ])->render(),
                                        ])
                                ),

                            Select::make('category')
                                ->label(__('report.column.category'))
                                ->placeholder(__('placeholder.select_one'))
                                ->options(Category::options())
                                ->enum(Category::class)
                                ->reactive()
                                ->required()
                                ->afterStateUpdated(function (callable $set) {
                                    $set('indicators', null);
                                }),
                        ]),

                    Select::make('indicators')
                        ->columnSpanFull()
                        ->label(__('report.column.indicators'))
                        ->placeholder(__('placeholder.select_many'))
                        ->options(
                            fn (callable $get) => Category::tryFrom((string) $get('category'))
                                ?->indicators()::options()
                        )
                        ->visible(fn (callable $get) => Category::tryFrom((string) $get('category')) !== null)
                        ->hintAction(
                            fn (Select $component, callable $get) => FormAction::make('select_all')
                                ->view('components.actions.link-action')
                                ->label(__('app.action.select_all'))
                                ->action(
                                    fn () => $component->state(
                                        Category::tryFrom((string) $get('category'))
                                            ?->indicators()::values()
                                    )
                                )
                        )
                        ->multiple()
                        ->required(),

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
                ]),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            //
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            ReportTableWidget::class,
        ];
    }
}
