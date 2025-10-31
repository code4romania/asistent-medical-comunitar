<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Schemas;

use App\Filament\Infolists\Components\BooleanEntry;
use App\Filament\Infolists\Components\Location;
use App\Filament\Schemas\Components\Subsection;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class StudiesInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                RepeatableEntry::make('studies')
                    ->contained(false)
                    ->columnSpanFull()
                    ->label(__('user.profile.section.studies'))
                    ->hiddenLabel()
                    ->schema([
                        Subsection::make()
                            ->icon(Heroicon::OutlinedAcademicCap)
                            ->columns()
                            ->schema([
                                TextEntry::make('name')
                                    ->label(__('field.study_name')),

                                TextEntry::make('type')
                                    ->label(__('field.study_type')),

                                TextEntry::make('institution')
                                    ->label(__('field.study_institution')),

                                TextEntry::make('duration')
                                    ->label(__('field.study_duration')),

                                Location::make()
                                    ->contained(false),

                                TextEntry::make('start_year')
                                    ->label(__('field.start_year')),

                                TextEntry::make('end_year')
                                    ->label(__('field.end_year')),
                            ]),
                    ]),

                Subsection::make()
                    ->heading(__('study.specialization_section'))
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->columns(2)
                    ->schema([
                        BooleanEntry::make('has_participated_specialization')
                            ->label(__('field.has_participated_specialization')),

                        BooleanEntry::make('has_graduated_specialization')
                            ->label(__('field.has_graduated_specialization')),
                    ]),
            ]);
    }
}
