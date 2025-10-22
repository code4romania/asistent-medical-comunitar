<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Activities\Tables;

use App\Enums\Activity\Event;
use App\Models\Activity;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class ActivitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query
                    ->whereNot('log_name', 'vulnerabilities')
                    // TODO: Re-add beneficiary filtering when needed
                    // ->where(function (Builder $query) {
                    //     $beneficiary = $this->getBeneficiary();

                    //     $query->whereMorphedTo('subject', $beneficiary)
                    //         ->orWhereMorphedTo('subject', $beneficiary->catagraphy);
                    // })
                    ->select([
                        'id',
                        'created_at',
                        'causer_type',
                        'causer_id',
                        'subject_type',
                        'subject_id',
                        'log_name',
                        'event',
                    ])
                    ->selectRaw('JSON_LENGTH(JSON_EXTRACT(properties, "$.attributes")) as changes_count');
            })
            ->columns([
                TextColumn::make('created_at')
                    ->label(__('activity.column.created_at'))
                    ->dateTime()
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('causer.full_name')
                    ->label(__('activity.column.causer'))
                    ->default(__('activity.no_causer'))
                    ->searchable()
                    ->toggleable(),

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

                TextColumn::make('changes_count')
                    ->label(__('activity.column.changes_count'))
                    ->toggleable()
                    ->sortable(),
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
                    ->options(Event::class)
                    ->multiple()
                    ->options([
                        'created' => __('activity.filter.event_created'),
                        'updated' => __('activity.filter.event_updated'),
                        'deleted' => __('activity.filter.event_deleted'),
                    ]),

                DateRangeFilter::make('created_at')
                    ->label(__('activity.column.created_at')),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
