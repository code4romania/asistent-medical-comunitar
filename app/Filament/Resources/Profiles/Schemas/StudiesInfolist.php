<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Schemas;

use App\Infolists\Components\BooleanEntry;
use App\Infolists\Components\Location;
use App\Infolists\Components\Subsection;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;

class StudiesInfolist
{
    public static function getSchema(): array
    {
        return [
            RepeatableEntry::make('studies')
                ->contained(false)
                ->columnSpanFull()
                ->label(__('user.profile.section.studies'))
                ->schema([
                    Subsection::make()
                        ->icon('heroicon-o-academic-cap')
                        ->columns(2)
                        ->schema([
                            TextEntry::make('name')
                                ->label(__('field.study_name')),

                            TextEntry::make('type')
                                ->label(__('field.study_type')),

                            TextEntry::make('institution')
                                ->label(__('field.study_institution')),

                            TextEntry::make('duration')
                                ->label(__('field.study_duration')),

                            Location::make(),

                            TextEntry::make('start_year')
                                ->label(__('field.start_year')),

                            TextEntry::make('end_year')
                                ->label(__('field.end_year')),
                        ]),
                ]),

            Subsection::make()
                ->heading(__('study.specialization_section'))
                ->icon('heroicon-o-document-text')
                ->columns(2)
                ->schema([
                    BooleanEntry::make('has_participated_specialization')
                        ->label(__('field.has_participated_specialization')),

                    BooleanEntry::make('has_graduated_specialization')
                        ->label(__('field.has_graduated_specialization')),
                ]),
        ];
    }
}
