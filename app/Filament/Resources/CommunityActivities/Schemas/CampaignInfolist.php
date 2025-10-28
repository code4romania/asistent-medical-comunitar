<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityActivities\Schemas;

use App\Filament\Infolists\Components\FileList;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class CampaignInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns()
            ->components([
                TextEntry::make('subtype')
                    ->label(__('field.type'))
                    ->columnSpanFull(),

                TextEntry::make('name')
                    ->label(__('field.activity')),

                TextEntry::make('organizer')
                    ->label(__('field.organizer')),

                TextEntry::make('nurse.activityCounty.name')
                    ->label(__('field.county'))
                    ->visible(fn () => auth()->user()->isAdmin()),

                TextEntry::make('location')
                    ->label(__('field.location')),

                Group::make([
                    TextEntry::make('date')
                        ->label(__('field.date'))
                        ->date(),

                    TextEntry::make('outside_working_hours')
                        ->label(__('field.hour')),
                ]),

                TextEntry::make('participants')
                    ->label(__('field.participants')),

                TextEntry::make('roma_participants')
                    ->label(__('field.roma_participants')),

                FileList::make('participants_list')
                    ->label(__('field.participants_list'))
                    ->collection('participants_list')
                    ->columnSpanFull(),

                TextEntry::make('notes')
                    ->label(__('field.notes'))
                    ->columnSpanFull(),
            ]);
    }
}
