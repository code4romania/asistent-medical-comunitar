<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Schemas;

use App\Filament\Infolists\Components\FileList;
use App\Filament\Infolists\Components\Location;
use App\Filament\Schemas\Components\Subsection;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class GeneralInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Subsection::make()
                    ->icon(Heroicon::OutlinedUser)
                    ->columns()
                    ->schema([
                        TextEntry::make('first_name')
                            ->label(__('field.first_name')),

                        TextEntry::make('last_name')
                            ->label(__('field.last_name')),

                        TextEntry::make('date_of_birth')
                            ->label(__('field.date_of_birth'))
                            ->date(),

                        TextEntry::make('gender')
                            ->label(__('field.gender')),

                        TextEntry::make('cnp')
                            ->label(__('field.cnp')),
                    ]),

                Subsection::make()
                    ->icon(Heroicon::OutlinedMapPin)
                    ->columns()
                    ->schema([
                        Location::make()
                            ->contained(false),

                        TextEntry::make('email')
                            ->label(__('field.email')),

                        TextEntry::make('phone')
                            ->label(__('field.phone')),
                    ]),

                Subsection::make()
                    ->icon(Heroicon::OutlinedDocument)
                    ->columns()
                    ->schema([
                        TextEntry::make('accreditation_number')
                            ->label(__('field.accreditation_number')),

                        TextEntry::make('accreditation_date')
                            ->label(__('field.accreditation_date'))
                            ->date(),

                        FileList::make('accreditation_document')
                            ->label(__('field.accreditation_document'))
                            ->collection('accreditation_document')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
