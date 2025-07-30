<?php

declare(strict_types=1);

namespace App\Filament\Resources\AppointmentResource\Widgets;

use App\Filament\Resources\AppointmentResource;
use App\Models\Appointment;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    protected string $modalWidth = 'xl';

    public function fetchEvents(array $fetchInfo): array
    {
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
                    'description' => \sprintf(
                        '#%d - %s',
                        $appointment->id,
                        $appointment->beneficiary->full_name
                    ),
                ],
            ])
            ->toArray();
    }

    public function onEventClick($event): void
    {
        if (! static::canView($event)) {
            return;
        }

        $this->redirect(AppointmentResource::getUrl('view', [
            'record' => $event['id'],
        ]));
    }

    public function onEventDrop(array $event, array $oldEvent, array $relatedEvents, array $delta, ?array $oldResource, ?array $newResource): bool
    {
        $this->resolveEventRecord($oldEvent)
            ->updateDateTime($event['start'], $event['end']);

        return false;
    }

    public function onEventResize(array $event, array $oldEvent, array $relatedEvents, array $startDelta, array $endDelta): bool
    {
        $this->resolveEventRecord($oldEvent)
            ->updateDateTime($event['start'], $event['end']);

        return false;
    }

    protected function resolveEventRecord($event): Appointment
    {
        return Appointment::findOrFail($event['id']);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(?array $event = null): bool
    {
        return false;
    }
}
