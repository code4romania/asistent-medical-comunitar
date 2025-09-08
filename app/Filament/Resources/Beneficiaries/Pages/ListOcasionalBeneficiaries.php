<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\Pages\ListBeneficiaries;
use Illuminate\Database\Eloquent\Builder;

class ListOcasionalBeneficiaries extends ListBeneficiaries
{
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->onlyOcasional();
    }
}
