<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Activities\Schemas;

use App\Models\Activity;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ActivityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('created_at')
                    ->label(__('activity.column.created_at'))
                    ->dateTime(),

                TextEntry::make('causer.full_name')
                    ->label(__('activity.column.causer'))
                    ->default(__('activity.no_causer')),

                TextEntry::make('log_name')
                    ->label(__('activity.column.section'))
                    ->formatStateUsing(fn (Activity $record) => __("activity.beneficiary.{$record->log_name}")),

                TextEntry::make('event')
                    ->label(__('activity.column.event'))
                    ->formatStateUsing(fn (Activity $record) => __("activity.event.{$record->event}")),

                // TODO: show changes in a better way
                // KeyValueEntry::make('properties')
                //     ->label(__('activity.column.properties'))
                //     ->columnSpanFull(),

            ]);
    }
}
