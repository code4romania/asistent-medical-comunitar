<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\Concerns\HasTabs;
use Filament\Actions\CreateAction;
use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\Users\UserResource;
use App\Filament\Resources\UserResource\Concerns;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

abstract class ListUsers extends ListRecords implements WithTabs
{
    use HasTabs;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
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
