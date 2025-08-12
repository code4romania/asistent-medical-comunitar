<?php

declare(strict_types=1);

namespace App\Filament\Resources\AppointmentResource\Schemas;

use App\Filament\Resources\BeneficiaryResource;
use App\Infolists\Components\Subsection;
use App\Models\Appointment;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Enums\MaxWidth;

class AppointmentInfolist
{
    public static function getSchema(): array
    {
        return [
            Section::make()
                ->schema([
                    Subsection::make()
                        ->heading(__('appointment.section.mandatory'))
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            Grid::make()
                                ->maxWidth(MaxWidth::TwoExtraLarge)
                                ->schema([
                                    TextEntry::make('id')
                                        ->label(__('field.id'))
                                        ->prefix('#'),

                                    TextEntry::make('beneficiary.full_name')
                                        ->label(__('field.beneficiary'))
                                        ->url(fn (Appointment $record) => BeneficiaryResource::geturl('view', [
                                            'record' => $record->beneficiary,
                                        ])),

                                    TextEntry::make('date')
                                        ->label(__('field.date'))
                                        ->date(),

                                    TextEntry::make('interval')
                                        ->label(__('field.interval_hours')),
                                ]),
                        ]),

                    Subsection::make()
                        ->heading(__('appointment.section.additional'))
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Group::make()
                                ->maxWidth(MaxWidth::ThreeExtraLarge)
                                ->schema([
                                    TextEntry::make('type')
                                        ->label(__('field.type')),

                                    TextEntry::make('location')
                                        ->label(__('field.location')),

                                    TextEntry::make('attendant')
                                        ->label(__('field.attendant')),
                                ]),
                        ]),

                    Subsection::make()
                        ->heading(__('appointment.section.notes'))
                        ->icon('heroicon-o-chat-bubble-bottom-center-text')
                        ->schema([
                            TextEntry::make('notes')
                                ->hiddenLabel()
                                ->html(),
                        ]),
                ]),
        ];
    }
}
