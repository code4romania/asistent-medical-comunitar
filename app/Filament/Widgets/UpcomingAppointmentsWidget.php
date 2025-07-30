<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Concerns\HasConditionalTableEmptyState;
use App\Filament\Resources\AppointmentResource;
use App\Filament\Tables\Columns\TextColumn;
use App\Models\Appointment;
use Closure;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Widgets\TableWidget;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class UpcomingAppointmentsWidget extends TableWidget
{
    use HasConditionalTableEmptyState;

    protected static ?int $sort = 30;

    public static function canView(): bool
    {
        return AppointmentResource::canViewAny();
    }

    protected function getTableHeading(): string
    {
        return __('appointment.label.plural');
    }

    protected function getTableQuery(): Builder
    {
        return Appointment::query()
            ->with([
                'interventions' => fn ($query) => $query->select([
                    'interventions.id',
                    'interventions.interventionable_type',
                    'interventions.interventionable_id',
                    'interventions.appointment_id',
                    'interventions.parent_id',
                ]),
            ])
            ->upcoming();
    }

    protected function getTableQueryStringIdentifier(): ?string
    {
        return 'appointments';
    }

    protected function getTableColumns(): array
    {
        return [
            Split::make([
                TextColumn::make('beneficiary.full_name')
                    ->label(__('field.beneficiary'))
                    ->size('sm')
                    ->extraAttributes([
                        'class' => 'font-semibold',
                    ]),

                TextColumn::make('beneficiary.status')
                    ->label(__('field.status'))
                    ->badge()
                    ->size('sm')
                    ->alignEnd(),
            ]),

            Stack::make([
                TextColumn::make('interventions')
                    ->color('text-gray-400')
                    ->icon('heroicon-m-bolt')
                    ->size('sm')
                    ->formatStateUsing(function (Collection $state) {
                        if ($state->count() === 1) {
                            return $state->first()->interventionable->service->name;
                        }

                        return trans_choice('intervention.services_count', $state->count());
                    }),

                TextColumn::make('date')
                    ->label(__('field.date'))
                    ->color('text-gray-400')
                    ->icon('heroicon-s-calendar')
                    ->size('sm')
                    ->date(),

                TextColumn::make('start_time')
                    ->label(__('field.start_time'))
                    ->color('text-gray-400')
                    ->icon('heroicon-s-clock')
                    ->size('sm'),
            ]),
        ];
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return fn (Appointment $record) => $record->url;
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [5];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->simplePaginate(
            $this->getTableRecordsPerPage() == -1 ? $query->count() : $this->getTableRecordsPerPage(),
            ['*'],
            $this->getTablePaginationPageName(),
        );
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'icon-empty-state';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return __('appointment.empty_upcoming.title');
    }
}
