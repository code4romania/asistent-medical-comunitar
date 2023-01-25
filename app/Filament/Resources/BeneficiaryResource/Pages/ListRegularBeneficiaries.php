<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use Illuminate\Database\Eloquent\Builder;

class ListRegularBeneficiaries extends ListBeneficiaries
{
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->onlyRegular();
    }
}
