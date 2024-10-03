<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Pages;

use App\Enums\Report\Standard\Category;
use App\Enums\Report\Status;
use App\Enums\Report\Type;
use App\Filament\Forms\Components\Card;
use App\Filament\Resources\ReportResource;
use App\Filament\Resources\ReportResource\Widgets\ReportTableWidget;
use App\Jobs\GenerateStandardReportJob;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class GenerateStandardReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        // $data['status'] = Status::PENDING;

        return $data;
    }

    protected function afterCreate(): void
    {
        GenerateStandardReportJob::dispatch($this->record, $this->form->getState());
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
                                ->options(Type::options())
                                ->enum(Type::class)
                                ->reactive()
                                ->required(),

                            Select::make('category')
                                ->label(__('report.column.category'))
                                ->placeholder(__('placeholder.select_one'))
                                ->options(Category::options())
                                ->enum(Category::class)
                                ->reactive()
                                ->required(),

                            Select::make('indicators')
                                ->label(__('report.column.indicators'))
                                ->placeholder(__('placeholder.select_one'))
                                ->options(
                                    fn (callable $get) => Category::tryFrom((string) $get('category'))
                                        ?->indicators()::options()
                                )
                                ->disableOptionWhen(function (callable $get, string $value) {
                                    $report = Category::tryFrom((string) $get('category'))
                                        ?->indicators()::tryFrom($value)
                                        ?->class();

                                    return \is_null($report) || ! class_exists($report);
                                })
                                ->visible(fn (callable $get) => Type::LIST->is($get('type')))
                                ->multiple()
                                ->required(),
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
