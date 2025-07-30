<?php

declare(strict_types=1);

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Concerns\HasConditionalTableEmptyState;
use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\AppointmentResource;
use App\Filament\Resources\AppointmentResource\Concerns;
use Filament\Pages;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;

class ListAppointments extends ListRecords implements WithTabs
{
    use Concerns\HasTabs;
    use HasConditionalTableEmptyState;

    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Pages\Actions\CreateAction::make(),
        ];
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return 'icon-empty-state';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return __('appointment.empty.title');
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return __('appointment.empty.description');
    }

    protected function getTableEmptyStateActions(): array
    {
        return [
            Tables\Actions\CreateAction::make()
                ->label(__('appointment.action.create'))
                ->url(static::getResource()::getUrl('create'))
                ->color('gray')
                ->hidden(fn () => $this->hasAlteredTableQuery()),
        ];
    }
}
