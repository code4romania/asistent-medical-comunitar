<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\Beneficiary\Status;
use App\Models\Appointment;
use App\Tables\Columns\BadgeColumn;
use App\Tables\Columns\TextColumn;
use Closure;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Widgets\TableWidget;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class UpcomingAppointmentsWidget extends TableWidget
{
    protected static ?int $sort = 30;

    protected function getTableHeading(): string
    {
        return __('appointment.label.plural');
    }

    protected function getTableQuery(): Builder
    {
        return Appointment::query()
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

                BadgeColumn::make('beneficiary.status')
                    ->label(__('field.status'))
                    ->size('xs')
                    ->enum(Status::options())
                    ->colors(Status::flipColors())
                    ->alignEnd(),
            ]),

            Stack::make([
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
}
