<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Concerns;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

abstract class ListUsers extends ListRecords implements WithTabs
{
    use Concerns\HasTabs;

    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->with([
                'activityCounty',
            ]);
    }
}
