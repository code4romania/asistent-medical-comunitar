<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\Tables\MediatorsTable;
use Filament\Tables\Table;

class ListMediators extends ListUsers
{
    public function table(Table $table): Table
    {
        return MediatorsTable::configure($table);
    }
}
