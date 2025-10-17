<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Filament\Resources\Appointments\AppointmentResource;
use App\Models\Appointment;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UpcomingAppointmentsWidget extends TableWidget
{
    protected static ?int $sort = 30;

    public static function canView(): bool
    {
        return AppointmentResource::canViewAny();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => Appointment::query()
                    ->with([
                        'interventions' => fn (HasMany $query) => $query
                            ->select([
                                'interventions.id',
                                'interventions.interventionable_type',
                                'interventions.interventionable_id',
                                'interventions.appointment_id',
                                'interventions.parent_id',
                            ]),
                    ])
                    ->upcoming()
            )
            ->heading(__('appointment.label.plural'))
            ->columns([
                Split::make([
                    TextColumn::make('beneficiary.full_name')
                        ->label(__('field.beneficiary'))
                        ->extraAttributes([
                            'class' => 'font-semibold',
                        ]),

                    TextColumn::make('beneficiary.status')
                        ->label(__('field.status'))
                        ->badge()
                        ->alignEnd(),
                ]),

                Stack::make([
                    TextColumn::make('interventions_count')
                        ->counts('interventions')
                        ->color('text-gray-400')
                        ->icon('heroicon-m-bolt')
                        ->formatStateUsing(
                            fn (int $state) => trans_choice('intervention.services_count', $state)
                        ),

                    TextColumn::make('date')
                        ->label(__('field.date'))
                        ->color('text-gray-400')
                        ->icon('heroicon-s-calendar')
                        ->date(),

                    TextColumn::make('start_time')
                        ->label(__('field.start_time'))
                        ->color('text-gray-400')
                        ->icon('heroicon-s-clock'),
                ]),
            ])

            ->recordUrl(fn (Appointment $record) => $record->url)
            ->defaultSort('id', 'desc')
            ->queryStringIdentifier('appointments')
            ->paginated([5]);
    }
}
