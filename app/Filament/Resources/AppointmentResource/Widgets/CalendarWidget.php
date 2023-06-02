<?php

declare(strict_types=1);

namespace App\Filament\Resources\AppointmentResource\Widgets;

use App\Models\Appointment;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo)
    {
        // You can use $fetchInfo to filter events by date.

        return Appointment::query()
            ->with('beneficiary:id,full_name')
            ->betweenDates($fetchInfo['start'], $fetchInfo['end'])
            ->get()
            ->map(fn (Appointment $appointment) => [
                'id' => $appointment->id,
                'title' => $appointment->type,
                'start' => $appointment->start,
                'end' => $appointment->end,
                'displayEventEnd' => true,
                'extendedProps' => [
                    'description' => sprintf(
                        '#%d - %s',
                        $appointment->id,
                        $appointment->beneficiary->full_name
                    ),
                ],
            ])
            ->debug()
            ->toArray();
    }
}
