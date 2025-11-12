<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\Tables\AdminsTable;
use Filament\Tables\Table;

class ListAdmins extends ListUsers
{
    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()->isAdmin(), 403);
    }

    public function table(Table $table): Table
    {
        return AdminsTable::configure($table);
    }
}
