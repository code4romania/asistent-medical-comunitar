<?php

declare(strict_types=1);

namespace App\Filament\Resources\Appointments\Widgets;

use App\Models\Appointment;
use Filament\Actions\Action;
use Guava\Calendar\Enums\CalendarViewType;
use Guava\Calendar\Filament\CalendarWidget as Widget;
use Guava\Calendar\ValueObjects\CalendarResource;
use Guava\Calendar\ValueObjects\EventDropInfo;
use Guava\Calendar\ValueObjects\EventResizeInfo;
use Guava\Calendar\ValueObjects\FetchInfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class CalendarWidget extends Widget
{
    protected CalendarViewType $calendarView = CalendarViewType::ResourceTimeGridWeek;

    protected bool $eventResizeEnabled = true;

    protected bool $eventDragEnabled = true;

    protected bool $eventClickEnabled = true;

    protected bool $dayMaxEvents = true;

    protected function getEvents(FetchInfo $info): Builder
    {
        return Appointment::query()
            ->with('beneficiary:id,full_name')
            ->betweenDates($info->start, $info->end);
    }

    protected function getResources(): Collection|array|Builder
    {
        return [
            CalendarResource::make('appointments')
                ->title(''),

        ];
    }

    public function getOptions(): array
    {
        return [
            'buttonText' => [
                'today' => __('calendar.button.today'),
            ],
        ];
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('month')
                ->label(__('calendar.view.month'))
                ->action(fn () => $this->setOption('view', CalendarViewType::DayGridMonth))
            // ->color($this->getView() === 'dayGridMonth' ? 'primary' : 'secondary')
            ,
        ];
    }

    protected function eventContent(): HtmlString|string
    {
        return view('components.calendar-event')->render();
    }

    public function onEventResize(EventResizeInfo $info, Model $event): bool
    {
        return $event->updateDateTime($info->event->getStart(), $info->event->getEnd());
    }

    protected function onEventDrop(EventDropInfo $info, Model $event): bool
    {
        return $event->updateDateTime($info->event->getStart(), $info->event->getEnd());
    }
}
