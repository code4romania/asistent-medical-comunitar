<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Pages;

use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListRegularBeneficiaries extends ListBeneficiaries
{
    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->onlyRegular());
    }
}
