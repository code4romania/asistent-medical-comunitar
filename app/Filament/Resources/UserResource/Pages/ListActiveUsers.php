<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages;

use Illuminate\Database\Eloquent\Builder;

class ListActiveUsers extends ListUsers
{
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->onlyActive();
    }
}
