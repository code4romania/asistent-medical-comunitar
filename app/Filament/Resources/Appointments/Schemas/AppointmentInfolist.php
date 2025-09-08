<?php

declare(strict_types=1);

namespace App\Filament\Resources\Appointments\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Support\Enums\Width;
use Filament\Schemas\Components\Group;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Infolists\Components\Subsection;
use App\Models\Appointment;
use Filament\Infolists\Components\TextEntry;

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
                                ->maxWidth(Width::TwoExtraLarge)
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
                                ->maxWidth(Width::ThreeExtraLarge)
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
