<?php

declare(strict_types=1);

namespace App\Filament\Resources\Appointments\Widgets;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Appointment::class;

    protected string $modalWidth = 'xl';

    protected function headerActions(): array
    {
        return [
            //
        ];
    }

    public function config(): array
    {
        return [
            'firstDay' => 1,
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek',
            ],
            'eventTimeFormat' => [
                'hour' => '2-digit',
                'minute' => '2-digit',
                'omitZeroMinute' => false,
            ],
            'aspectRatio' => 1.35,
            'dayMaxEvents' => true,

        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        return Appointment::query()
            ->with('beneficiary:id,full_name')
            ->betweenDates($fetchInfo['start'], $fetchInfo['end'])
            ->get()
            ->map->toEventData()
            ->toArray();
    }

    public function onEventDrop(array $event, array $oldEvent, array $relatedEvents, array $delta, ?array $oldResource, ?array $newResource): bool
    {
        return $this->update($event);
    }

    public function onEventResize(array $event, array $oldEvent, array $relatedEvents, array $startDelta, array $endDelta): bool
    {
        return $this->update($event);
    }

    private function update(array $event): bool
    {
        $this->resolveRecord($event['id'])
            ->updateDateTime($event['start'], $event['end']);

        return false;
    }

    public function eventContent(): string
    {
        return <<<'JS'
            function({ event, timeText }) {
                const html = `
                    <div class="fc-event-content">
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-bold fc-event-time">${timeText}</span>
                        </div>

                        <div class="overflow-hidden text-ellipsis whitespace-nowrap">
                            ${event.extendedProps.description}
                        </div>
                    </div>
                `;

                return { html };
            }
        JS;
    }
}
