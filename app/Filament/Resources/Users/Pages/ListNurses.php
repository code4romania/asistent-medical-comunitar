<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\Tables\NursesTable;
use Filament\Tables\Table;

class ListNurses extends ListUsers
{
    public function table(Table $table): Table
    {
        return NursesTable::configure($table);
    }
}
