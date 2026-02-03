<?php

declare(strict_types=1);

namespace App\Filament\Resources\Reports\Schemas;

use App\Enums\Report\Standard\Category;
use App\Enums\Report\Type;
use App\Filament\Forms\Components\Select;
use App\Models\County;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Malzariey\FilamentDaterangepickerFilter\Fields\DateRangePicker;

class ReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->columns(3)
                    ->footerActionsAlignment(Alignment::End)
                    ->footerActions([
                        Action::make('cancel')
                            ->label(__('report.action.cancel'))
                            ->color('gray')
                            ->action(function (Page $livewire) {
                                $livewire->form->fill();
                            }),

                        Action::make('create')
                            ->label(__('report.action.generate'))
                            ->submit('create')
                            ->keyBindings(['mod+s'])
                            ->color('warning'),
                    ])
                    ->components([
                        Select::make('type')
                            ->label(__('report.column.type'))
                            ->placeholder(__('placeholder.select_one'))
                            ->visible(fn () => auth()->user()->isNurse())
                            ->options(Type::class)
                            ->live()
                            ->required(),

                        Select::make('nurses')
                            ->label(__('report.column.nurses'))
                            ->placeholder(__('placeholder.select_many'))
                            ->visible(fn () => auth()->user()->isCoordinator())
                            ->minItems(1)
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
                            ->options(Category::class)
                            ->live()
                            ->required()
                            ->afterStateUpdated(function (Set $set) {
                                $set('indicators', null);
                            }),

                        DateRangePicker::make('date')
                            ->defaultLastYear()
                            ->maxDate(today()),

                        Select::make('indicators')
                            ->columnSpanFull()
                            ->label(__('report.column.indicators'))
                            ->placeholder(__('placeholder.select_many'))
                            ->options(function (Get $get) {
                                $indicator = $get('category')?->indicator();

                                return collect($indicator::options())
                                    ->reject(function (string $label, string $value) use ($indicator) {
                                        $reportQuery = $indicator::tryFrom($value)?->class();

                                        return \is_null($reportQuery) || ! class_exists($reportQuery);
                                    });
                            })
                            ->visible(fn (Get $get) => $get('category') !== null)
                            ->multiple()
                            ->selectAll()
                            ->required(),
                    ]),
            ]);
    }
}
