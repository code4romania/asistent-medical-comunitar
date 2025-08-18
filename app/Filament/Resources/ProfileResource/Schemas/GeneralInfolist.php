<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Schemas;

use App\Infolists\Components\FileList;
use App\Infolists\Components\Location;
use App\Infolists\Components\Subsection;
use Filament\Infolists\Components\TextEntry;

class GeneralInfolist
{
    public static function getSchema(): array
    {
        return [
            Subsection::make()
                ->icon('heroicon-o-user')
                ->columns(2)
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
                ->icon('heroicon-o-map-pin')
                ->columns(2)
                ->schema([
                    Location::make(),

                    TextEntry::make('email')
                        ->label(__('field.email')),

                    TextEntry::make('phone')
                        ->label(__('field.phone')),
                ]),

            Subsection::make()
                ->icon('heroicon-o-document')
                ->columns(2)
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
        ];
    }
}
