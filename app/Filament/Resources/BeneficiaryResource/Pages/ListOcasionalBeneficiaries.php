<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use Illuminate\Database\Eloquent\Builder;

class ListOcasionalBeneficiaries extends ListBeneficiaries
{
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->onlyOcasional();
    }
}
