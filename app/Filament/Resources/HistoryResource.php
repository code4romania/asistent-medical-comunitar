<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Models\Activity;
use App\Tables\Columns\TextColumn;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class HistoryResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static bool $shouldRegisterNavigation = false;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label(__('activity.column.created_at'))
                    ->formatStateUsing(fn (Activity $record) => $record->created_at->toFormattedDateTime())
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('causer.full_name')
                    ->label(__('activity.column.causer'))
                    ->default(__('activity.no_causer'))
                    ->searchable()
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('log_name')
                    ->label(__('activity.column.section'))
                    ->formatStateUsing(fn (Activity $record) => __("activity.beneficiary.{$record->log_name}"))
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('event')
                    ->label(__('activity.column.event'))
                    ->formatStateUsing(fn (Activity $record) => __("activity.event.{$record->event}"))
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('properties')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable()
                    ->label(__('activity.column.change'))
                    ->limit(75)
                    ->wrap(),
            ])
            ->filters([
                SelectFilter::make('log_name')
                    ->label(__('activity.column.section'))
                    ->multiple()
                    ->options([
                        'default' => __('activity.beneficiary.default'),
                        'catagraphy' => __('activity.beneficiary.catagraphy'),
                    ]),

                SelectFilter::make('event')
                    ->label(__('activity.column.event'))
                    ->multiple()
                    ->options([
                        'created' => __('activity.filter.event_created'),
                        'updated' => __('activity.filter.event_updated'),
                        'deleted' => __('activity.filter.event_deleted'),
                    ]),

                Filter::make('created_at')
                    ->columns()
                    ->form([
                        DatePicker::make('logged_from')
                            ->label(__('activity.filter.logged_from'))
                            ->placeholder(
                                fn ($state): string => today()
                                    ->setDay(17)
                                    ->setMonth(11)
                                    ->subYear()
                                    ->toFormattedDate()
                            ),

                        DatePicker::make('logged_until')
                            ->label(__('activity.filter.logged_until'))
                            ->placeholder(
                                fn ($state): string => today()
                                    ->toFormattedDate()
                            ),
                    ])
                    ->query(
                        fn (Builder $query, array $data): Builder => $query->betweenDates(
                            data_get($data, 'logged_from'),
                            data_get($data, 'logged_until'),
                        )
                    )
                    ->indicateUsing(
                        fn (array $data) => collect(['logged_from', 'logged_until'])
                            ->mapWithKeys(function (string $filter) use ($data) {
                                $value = data_get($data, $filter);

                                if (! \is_null($value)) {
                                    $value = __('activity.indicator.logged_from', [
                                        'date' => Carbon::parse($value)->toFormattedDate(),
                                    ]);
                                }

                                return [$filter => $value];
                            })
                            ->filter()
                            ->all()
                    ),
            ])
            ->bulkActions([]);
    }
}
