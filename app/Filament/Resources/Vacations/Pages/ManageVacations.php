<?php

declare(strict_types=1);

namespace App\Filament\Resources\Vacations\Pages;

use App\Concerns\HasConditionalTableEmptyState;
use App\Filament\Resources\Vacations\VacationResource;
use App\Models\Vacation;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Tables;

class ManageVacations extends ManageRecords
{
    use HasConditionalTableEmptyState;

    protected static string $resource = VacationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->using(function (array $data) {
                    $data['nurse_id'] = auth()->id();

                    return Vacation::create($data);
                }),
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

        return __('vacation.empty.title');
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return __('vacation.empty.description');
    }

    protected function getTableEmptyStateActions(): array
    {
        return [
            CreateAction::make()
                ->using(function (array $data) {
                    $data['nurse_id'] = auth()->id();

                    return Vacation::create($data);
                })
                ->color('gray')
                ->hidden(fn () => $this->hasAlteredTableQuery() || ! static::getResource()::canCreate()),
        ];
    }
}
