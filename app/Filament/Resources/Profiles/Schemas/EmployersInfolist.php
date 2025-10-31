<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Schemas;

use App\Filament\Infolists\Components\BooleanEntry;
use App\Filament\Infolists\Components\Location;
use App\Filament\Schemas\Components\Subsection;
use App\Models\Profile\Employer;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class EmployersInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                RepeatableEntry::make('employers')
                    ->contained(false)
                    ->label(__('user.profile.section.employers'))
                    ->hiddenLabel()
                    ->components([
                        Subsection::make()
                            ->icon(Heroicon::OutlinedBuildingOffice)
                            ->columns()
                            ->components([
                                TextEntry::make('name')
                                    ->label(__('field.employer_name')),

                                TextEntry::make('type')
                                    ->label(__('field.employer_type')),

                                TextEntry::make('funding')
                                    ->label(__('field.funding')),

                                TextEntry::make('project')
                                    ->label(__('field.employer_project'))
                                    ->hidden(fn (Employer $record) => blank($record->project))
                                    ->columnSpanFull(),

                                Location::make()
                                    ->contained(false),

                                TextEntry::make('email')
                                    ->label(__('field.employer_email')),

                                TextEntry::make('phone')
                                    ->label(__('field.employer_phone')),

                                TextEntry::make('start_date')
                                    ->label(__('field.start_date'))
                                    ->date(),

                                TextEntry::make('end_date')
                                    ->label(__('field.end_date'))
                                    ->placeholder(__('field.employer_ongoing'))
                                    ->date(),

                                BooleanEntry::make('has_gp_agreement')
                                    ->label(__('field.has_gp_agreement')),

                                TextEntry::make('gp_name')
                                    ->label(__('field.gp_name'))
                                    ->hidden(fn (Employer $record) => ! $record->has_gp_agreement),

                                TextEntry::make('gp_email')
                                    ->label(__('field.gp_email'))
                                    ->hidden(fn (Employer $record) => ! $record->has_gp_agreement),

                                TextEntry::make('gp_phone')
                                    ->label(__('field.gp_phone'))
                                    ->hidden(fn (Employer $record) => ! $record->has_gp_agreement),
                            ]),
                    ]),
            ]);
    }
}
