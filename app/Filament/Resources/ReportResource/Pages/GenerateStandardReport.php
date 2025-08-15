<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Pages;

use App\Enums\Report\Standard\Category;
use App\Enums\Report\Type;
use App\Filament\Resources\ReportResource;
use App\Filament\Resources\ReportResource\Widgets\ReportTableWidget;
use App\Forms\Components\Select;
use App\Jobs\GenerateReport;
use App\Models\County;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Resources\Pages\CreateRecord;

class GenerateStandardReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;

    protected static bool $canCreateAnother = false;

    protected function afterCreate(): void
    {
        $data = $this->form->getState();

        if (auth()->user()->isNurse()) {
            $job = match ($this->record->type) {
                Type::LIST => GenerateReport\Standard\Nurse\GenerateListReportJob::class,
                Type::STATISTIC => GenerateReport\Standard\Nurse\GenerateStatisticReportJob::class,
            };
        }

        if (auth()->user()->isCoordinator()) {
            $job = GenerateReport\Standard\Coordinator\GenerateStatisticReportJob::class;
        }

        if (auth()->user()->isAdmin()) {
            $job = GenerateReport\Standard\Admin\GenerateStatisticReportJob::class;
        }

        $job::dispatch($this->record, $data);
    }

    public function getTitle(): string
    {
        return ucfirst(__('report.label.plural'));
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make()
                ->columns(3)
                ->footerActions([
                    Action::make('cancel')
                        ->label(__('report.action.cancel'))
                        ->url($this->previousUrl ?? static::getResource()::getUrl())
                        ->color('gray'),

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
                                ->live()
                                ->required(),

                            Select::make('nurses')
                                ->label(__('report.column.nurses'))
                                ->placeholder(__('placeholder.select_many'))
                                ->visible(fn () => auth()->user()->isCoordinator())
                                ->allowHtml()
                                ->multiple()
                                ->selectAll()
                                ->options(
                                    fn () => User::query()
                                        ->onlyNurses()
                                        ->activatesInCounty(auth()->user()->county_id)
                                        ->withActivityAreas()
                                        ->get()
                                        ->mapWithKeys(fn (User $nurse) => [
                                            $nurse->getKey() => view('forms.components.option-label', [
                                                'name' => $nurse->full_name,
                                                'suffix' => $nurse->activityCities
                                                    ->pluck('name')
                                                    ->join(', '),
                                            ])->render(),
                                        ])
                                ),

                            Select::make('counties')
                                ->label(__('report.column.counties'))
                                ->placeholder(__('placeholder.select_many'))
                                ->visible(fn () => auth()->user()->isAdmin())
                                ->multiple()
                                ->selectAll()
                                ->options(fn () => County::pluck('name', 'id')),

                            Select::make('category')
                                ->label(__('report.column.category'))
                                ->placeholder(__('placeholder.select_one'))
                                ->options(Category::options())
                                ->enum(Category::class)
                                ->live()
                                ->required()
                                ->afterStateUpdated(function (callable $set) {
                                    $set('indicators', null);
                                }),
                        ]),

                    Select::make('indicators')
                        ->columnSpanFull()
                        ->label(__('report.column.indicators'))
                        ->placeholder(__('placeholder.select_many'))
                        ->options(function (callable $get) {
                            $indicator = Category::tryFrom((string) $get('category'))
                                ?->indicator();

                            return collect($indicator::options())
                                ->reject(function (string $label, string $value) use ($indicator) {
                                    $reportQuery = $indicator::tryFrom($value)?->class();

                                    return \is_null($reportQuery) || ! class_exists($reportQuery);
                                });
                        })
                        ->visible(fn (callable $get) => Category::tryFrom((string) $get('category')) !== null)
                        ->multiple()
                        ->selectAll()
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

    protected function getCreatedNotificationTitle(): ?string
    {
        return null;
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
