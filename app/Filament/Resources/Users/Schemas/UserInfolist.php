<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Schemas;

use App\Filament\Infolists\Components\Location;
use App\Filament\Schemas\Components\Subsection;
use App\Models\User;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->components([
                        Subsection::make()
                            ->icon(Heroicon::OutlinedUser)
                            ->columns()
                            ->components([
                                TextEntry::make('first_name')
                                    ->label(__('field.first_name')),

                                TextEntry::make('last_name')
                                    ->label(__('field.last_name')),

                                TextEntry::make('email')
                                    ->label(__('field.email')),

                                TextEntry::make('phone')
                                    ->label(__('field.phone')),

                                TextEntry::make('role')
                                    ->label(__('field.role')),

                                Location::make()
                                    ->contained(false)
                                    ->city(false)
                                    ->visible(fn (User $record) => $record->isCoordinator())
                                    ->columnSpan(1),

                            ]),
                    ]),

            ]);
    }
}
