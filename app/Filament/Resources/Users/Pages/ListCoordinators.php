<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\Tables\CoordinatorsTable;
use Filament\Tables\Table;

class ListCoordinators extends ListUsers
{
    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()->isAdmin(), 403);
    }

    public function table(Table $table): Table
    {
        return CoordinatorsTable::configure($table);
    }
}
