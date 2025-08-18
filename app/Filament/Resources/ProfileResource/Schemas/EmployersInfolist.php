<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Schemas;

use App\Infolists\Components\BooleanEntry;
use App\Infolists\Components\Location;
use App\Infolists\Components\Subsection;
use App\Models\Profile\Employer;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;

class EmployersInfolist
{
    public static function getSchema(): array
    {
        return [
            RepeatableEntry::make('employers')
                ->contained(false)
                ->columnSpanFull()
                ->label(__('user.profile.section.employers'))
                ->schema([
                    Subsection::make()
                        ->icon('heroicon-o-building-office')
                        ->columns(2)
                        ->schema([
                            TextEntry::make('name')
                                ->label(__('field.employer_name')),

                            TextEntry::make('type')
                                ->label(__('field.employer_type')),

                            TextEntry::make('funding')
                                ->label(__('field.funding')),

                            TextEntry::make('project')
                                ->label(__('field.employer_project'))
                                ->hidden(fn (Employer $record) => empty($record->project))
                                ->columnSpanFull(),

                            Location::make(),

                            TextEntry::make('email')
                                ->label(__('field.employer_email')),

                            TextEntry::make('phone')
                                ->label(__('field.employer_phone')),

                            TextEntry::make('start_date')
                                ->label(__('field.start_date'))
                                ->date(),

                            TextEntry::make('end_date')
                                ->label(__('field.end_date'))
                                ->date(),
                            // ->default(__('field.employer_ongoing'))
                            // ->date(),

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

        ];
    }
}
