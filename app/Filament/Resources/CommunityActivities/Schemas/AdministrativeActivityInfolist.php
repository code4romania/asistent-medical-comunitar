<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityActivities\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class AdministrativeActivityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns()
            ->components([
                TextEntry::make('subtype')
                    ->label(__('field.type')),

                Group::make()
                    ->schema([
                        TextEntry::make('nurse.full_name')
                            ->label(__('field.nurse'))
                            ->visible(fn (?string $state): bool => ! auth()->user()->isNurse() && filled($state)),

                        TextEntry::make('mediator.full_name')
                            ->label(__('field.mediator'))
                            ->visible(fn (?string $state): bool => ! auth()->user()->isMediator() && filled($state)),
                    ]),

                TextEntry::make('name')
                    ->label(__('field.activity')),

                TextEntry::make('nurse.activityCounty.name')
                    ->label(__('field.county'))
                    ->visible(fn () => auth()->user()->isAdmin()),

                Group::make([
                    TextEntry::make('date')
                        ->label(__('field.date'))
                        ->date(),

                    TextEntry::make('outside_working_hours')
                        ->label(__('field.hour')),
                ]),

                TextEntry::make('notes')
                    ->label(__('field.notes'))
                    ->columnSpanFull(),
            ]);
    }
}
