<?php

declare(strict_types=1);

namespace App\Filament\Resources\AppointmentResource\Widgets;

use App\Filament\Resources\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Appointment::class;

    public function fetchEvents(array $info): array
    {
        return Appointment::query()
            ->with('beneficiary:id,full_name')
            ->betweenDates($info['start'], $info['end'])
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

    protected function headerActions(): array
    {
        return [
            //
        ];
    }

    public function onEventClick(array $event): void
    {
        if (! static::canView()) {
            return;
        }

        $this->redirect(AppointmentResource::getUrl('view', [
            'record' => $event['id'],
        ]));
    }

    public function onEventDrop(array $event, array $oldEvent, array $relatedEvents, array $delta, ?array $oldResource, ?array $newResource): bool
    {
        $this->resolveRecord($oldEvent['id'])
            ->updateDateTime($event['start'], $event['end']);

        return false;
    }

    public function onEventResize(array $event, array $oldEvent, array $relatedEvents, array $startDelta, array $endDelta): bool
    {
        $this->resolveRecord($oldEvent['id'])
            ->updateDateTime($event['start'], $event['end']);

        return false;
    }
}
