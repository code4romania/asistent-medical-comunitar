<?php

declare(strict_types=1);

namespace App\Tables\Columns;

use App\Filament\Resources\BeneficiaryResource;
use App\Models\Beneficiary;
use Filament\Tables\Columns\ViewColumn;

class HouseholdFamiliesColumn extends ViewColumn
{
    protected string $view = 'tables.columns.household-families-column';

    public function beneficiaryUrl(Beneficiary $record): string
    {
        return BeneficiaryResource::getUrl('view', ['record' => $record]);
    }
}
