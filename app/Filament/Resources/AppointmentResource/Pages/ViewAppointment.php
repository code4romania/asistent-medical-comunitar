<?php

declare(strict_types=1);

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Forms\Components\Card;
use App\Filament\Forms\Components\Subsection;
use App\Filament\Forms\Components\Value;
use App\Filament\Resources\AppointmentResource;
use App\Filament\Resources\BeneficiaryResource;
use App\Models\Appointment;
use Filament\Forms\Components\Grid;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewAppointment extends ViewRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function getTitle(): string
    {
        return __('appointment.header.view', [
            'beneficiary' => $this->getRecord()->beneficiary->full_name,
            'date' => $this->getRecord()->date->toFormattedDate(),
            'start_time' => $this->getRecord()->start_time,
        ]);
    }

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Card::make()
                    ->schema([
                        Subsection::make()
                            ->title(__('appointment.section.mandatory'))
                            ->icon('heroicon-o-document-text')
                            ->columns(4)
                            ->schema([
                                Value::make('id')
                                    ->label(__('field.id')),

                                Value::make('beneficiary.full_name')
                                    ->label(__('field.beneficiary'))
                                    ->url(fn (Appointment $record) => BeneficiaryResource::geturl('view', $record->beneficiary)),

                                Grid::make(4)
                                    ->columnSpanFull()
                                    ->schema([
                                        Value::make('date')
                                            ->label(__('field.date')),

                                        Value::make('interval')
                                            ->label(__('field.interval_hours')),
                                    ]),
                            ]),

                        Subsection::make()
                            ->title(__('appointment.section.additional'))
                            ->icon('heroicon-o-information-circle')
                            ->columns(3)
                            ->schema([
                                Value::make('type')
                                    ->label(__('field.type'))
                                    ->columnSpan(2),

                                Value::make('location')
                                    ->label(__('field.location'))
                                    ->columnSpan(2),

                                Value::make('attendant')
                                    ->label(__('field.attendant'))
                                    ->columnSpan(2),
                            ]),

                        Subsection::make()
                            ->title(__('appointment.section.notes'))
                            ->icon('heroicon-o-annotation')
                            ->schema([
                                Value::make('notes')
                                    ->disableLabel(),
                            ]),
                    ]),
            ]);
    }
}
